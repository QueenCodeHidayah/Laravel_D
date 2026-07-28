<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Review;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon; 

class ReportController extends Controller
{
    // 1. Menampilkan Tabel Laporan (Hanya Admin & Kasubag)
    public function index()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kasubag') {
            abort(403, 'Akses ditolak.');
        }
        $reports = Report::with('user')->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    // 2. Menampilkan Form Lapor (Mahasiswa)
    public function create()
    {
        return view('reports.create');
    }

    // Fungsi untuk menampilkan riwayat laporan milik mahasiswa yang sedang login
    public function history()
    {
        $reports = Report::where('user_id', auth()->id())->latest()->get();
        return view('reports.history', compact('reports'));
    }

    // 3. Process Simpan Laporan ke Database
    public function store(Request $request)
    {
        $request->validate([
            'lantai' => 'required',
            'ruangan' => 'required',
            'nama_barang' => 'required|string|max:255',
            'tingkat_kerusakan' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('laporan', 'public');

        Report::create([
            'user_id' => auth()->id(),
            'lantai' => $request->lantai,
            'wing' => $request->wing,
            'ruangan' => $request->ruangan,
            'nama_barang' => $request->nama_barang,
            'tingkat_kerusakan' => $request->tingkat_kerusakan,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'status' => 'Terkirim',
        ]);

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil terkirim!');
    }

    // 4. Update Status Langsung (Update Cepat dari Tabel Index)
    public function updateStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->status = $request->status;
        $report->save();

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    // 5. Menampilkan Halaman Edit Laporan (Admin)
    public function edit($id)
    {
        $report = Report::with('user')->findOrFail($id);
        return view('admin.reports.edit', compact('report'));
    }

    // 6. Update Data Laporan (Edit Lengkap)
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $report->update([
            'nama_barang' => $request->nama_barang,
            'status'      => $request->status,
            'deskripsi'   => $request->deskripsi,
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Data laporan diperbarui!');
    }

    // 7. Hapus Laporan & Fotonya
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        
        if ($report->foto) {
            Storage::disk('public')->delete($report->foto);
        }

        $report->delete();

        return back()->with('success', 'Laporan telah dihapus.');
    }

    // 8. Melihat Detail Laporan (Admin & Pemilik Laporan)
    public function show($id)
    {
        $report = Report::with('user')->findOrFail($id);
        
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kasubag' && $report->user_id !== auth()->id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('reports.show', compact('report'));
    }

    // FITUR: Download Excel (SUDAH AMAN DARI FILE CORRUPT/RUSAK)
    public function exportExcel(Request $request) 
    { 
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kasubag') {
            abort(403, 'Anda tidak memiliki otoritas mengunduh dokumen ini.');
        }
        
        $query = Report::with('user');

        // Logika Penyaringan Tanggal (Jika diisi oleh User)
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date != '' && $request->end_date != '') {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $reports = $query->latest()->get();

        // 🟢 PERBAIKAN DI SINI: Bersihkan output buffer agar file excel tidak corrupt saat didownload
        if (ob_get_contents()) {
            ob_end_clean();
        }

        // Oper data variabel $reports yang sudah difilter ke dalam class anonymous Excel
        return Excel::download(new class($reports) implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents {
            
            protected $filteredReports;

            public function __construct($reports)
            {
                $this->filteredReports = $reports;
            }

            public function collection()
            {
                return $this->filteredReports;
            }

            public function headings(): array
            {
                return [
                    'ID Laporan', 'Nama Pelapor', 'Lokasi Lantai', 'Ruangan', 
                    'Nama Barang', 'Tingkat Kerusakan', 'Status Penanganan', 'Tanggal Masuk'
                ];
            }

            public function map($report): array
            {
                return [
                    'REP-' . str_pad($report->id, 3, '0', STR_PAD_LEFT),
                    $report->user->name,
                    'Lantai ' . $report->lantai,
                    $report->ruangan,
                    $report->nama_barang,
                    $report->tingkat_kerusakan,
                    $report->status,
                    $report->created_at->format('d-m-Y')
                ];
            }

            public function styles(Worksheet $sheet)
            {
                return [
                    1 => [
                        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Segoe UI'],
                        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']]
                    ],
                ];
            }

            public function registerEvents(): array
            {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        $sheet = $event->sheet->getDelegate();
                        $highestRow = $sheet->getHighestRow();
                        $summaryRow = $highestRow + 3;
                        
                        if ($highestRow < 2) { $highestRow = 2; }

                        $sheet->setCellValue('E' . $summaryRow, 'TOTAL RUSAK RINGAN');
                        $sheet->setCellValue('F' . $summaryRow, '=COUNTIF(F2:F'.$highestRow.', "Ringan")');
                        
                        $sheet->setCellValue('E' . ($summaryRow + 1), 'TOTAL RUSAK SEDANG');
                        $sheet->setCellValue('F' . ($summaryRow + 1), '=COUNTIF(F2:F'.$highestRow.', "Sedang")');
                        
                        $sheet->setCellValue('E' . ($summaryRow + 2), 'TOTAL RUSAK PARAH');
                        $sheet->setCellValue('F' . ($summaryRow + 2), '=COUNTIF(F2:F'.$highestRow.', "Parah")');
                        
                        $sheet->setCellValue('E' . ($summaryRow + 3), 'TOTAL KESELURUHAN LAPORAN');
                        $sheet->setCellValue('F' . ($summaryRow + 3), '=COUNTA(A2:A'.$highestRow.')');

                        $sheet->getStyle('E'.$summaryRow.':F'.($summaryRow+3))->getFont()->setBold(true)->setName('Segoe UI');
                        $sheet->getStyle('F'.$summaryRow.':F'.($summaryRow+3))->getAlignment()->setHorizontal('center');
                        
                        $sheet->getStyle('F'.$summaryRow)->getFill()->setFillType('solid')->getStartColor()->setRGB('FEF3C7');
                        $sheet->getStyle('F'.($summaryRow+1))->getFill()->setFillType('solid')->getStartColor()->setRGB('FFEDD5');
                        $sheet->getStyle('F'.($summaryRow+2))->getFill()->setFillType('solid')->getStartColor()->setRGB('FEE2E2');

                        foreach (range('A', 'H') as $col) {
                            $sheet->getColumnDimension($col)->setAutoSize(true);
                        }
                    },
                ];
            }
        }, 'Laporan_Sarpras_Hidayah_Pro.xlsx');
    }

    // 9. Fungsi untuk User menyimpan Review baru
    public function storeReview(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        return back()->with('success', 'Terima kasih! Review pro kamu berhasil disimpan untuk statistik fakultas.');
    }
 
    // 10. Fungsi untuk Admin melihat semua review mahasiswa
    public function viewReviews()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kasubag') {
            abort(403, 'Akses khusus administrator.');
        }

        $reviews = Review::with('user')->latest()->get();
        $rataRata = Review::avg('rating') ?? 0;

        return view('admin.reviews.index', compact('reviews', 'rataRata'));
    }

    // 11. Fungsi agar USER bisa melihat daftar review milik dirinya sendiri
    public function userReviews()
    {
        $reviews = Review::where('user_id', auth()->id())->latest()->get();
        return view('admin.users.reviews.index', compact('reviews'));
    }

    // 12. Fungsi HAPUS REVIEW
    public function destroyReview($id)
    {
        $review = Review::findOrFail($id);

        if (auth()->id() === $review->user_id || auth()->user()->role === 'admin') {
            $review->delete();
            return back()->with('success', 'Ulasan kepuasan berhasil dihapus dari sistem!');
        }

        return back()->with('error', 'Kamu tidak punya akses untuk menghapus ulasan ini.');
    }

    // TAMBAHAN FITUR: Download PDF (Sudah Diperbaiki Sistem Filternya)
    public function exportPdf(Request $request) 
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'kasubag') {
            abort(403, 'Anda tidak memiliki otoritas mengunduh dokumen ini.');
        }
        
        $query = Report::with('user');

        // Logika penyaringan tanggal yang sama untuk PDF
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date != '' && $request->end_date != '') {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $reports = $query->latest()->get(); 

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('admin.reports.pdf', compact('reports'))->render()); 
        
        return $pdf->download('Laporan_Sarpras_Hidayah.pdf');
    }

    // ==========================================
    // SEKSI TAMBAHAN: MANAJEMEN CRUD PANDUAN (KHUSUS ADMIN)
    // ==========================================

    // A. Menampilkan Halaman Panduan (Bisa diakses Mahasiswa, Admin, Kasubag)
    public function viewPanduan()
    {
        $guides = Guide::latest()->get();
        return view('panduan.index', compact('guides'));
    }

    // B. Form Tambah Panduan (Hanya Admin)
    public function createPanduan()
    {
        if (auth()->user()->role !== 'admin') { 
            abort(403, 'Hanya admin yang dapat menambah panduan.'); 
        }
        return view('admin.guides.create');
    }

    // C. Simpan Panduan Baru (Hanya Admin)
    public function storePanduan(Request $request)
    {
        if (auth()->user()->role !== 'admin') { 
            abort(403, 'Akses ditolak.'); 
        }
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'isi' => 'required|string',
            'ikon' => 'required|string',
        ]);

        Guide::create($request->all());
        return redirect()->route('panduan')->with('success', 'Panduan fasilitas baru berhasil diterbitkan!');
    }

    // D. Form Edit Panduan (Hanya Admin)
    public function editPanduan($id)
    {
        if (auth()->user()->role !== 'admin') { 
            abort(403, 'Hanya admin yang dapat mengubah panduan.'); 
        }
        $guide = Guide::findOrFail($id);
        return view('admin.guides.edit', compact('guide'));
    }

    // E. Update Data Panduan (Hanya Admin)
    public function updatePanduan(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') { 
            abort(403, 'Akses ditolak.'); 
        }
        $guide = Guide::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'isi' => 'required|string',
            'ikon' => 'required|string',
        ]);

        $guide->update($request->all());
        return redirect()->route('panduan')->with('success', 'Panduan berhasil diperbarui!');
    }

    // F. Hapus Data Panduan (Hanya Admin)
    public function destroyPanduan($id)
    {
        if (auth()->user()->role !== 'admin') { 
            abort(403, 'Akses ditolak.'); 
        }
        $guide = Guide::findOrFail($id);
        $guide->delete();

        return back()->with('success', 'Panduan telah dihapus dari sistem.');
    }
}