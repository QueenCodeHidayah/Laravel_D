<!DOCTYPE html>
<html>
<head>
    <title>Rekap Laporan Fasilitas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { bg-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>FAKULTAS SAINS DAN TEKNOLOGI</h2>
        <p>Laporan Rekapitulasi Kerusakan Fasilitas Kampus</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pelapor</th>
                <th>Barang</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $key => $report)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $report->created_at->format('d/m/Y') }}</td>
                <td>{{ $report->user->name }}</td>
                <td>{{ $report->nama_barang }}</td>
                <td>{{ $report->lantai }} - {{ $report->ruangan }}</td>
                <td>{{ $report->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
        <br><br>
        <p>(_______________________)</p>
        <p>Admin Sarpras Saintek</p>
    </div>
</body>
</html>