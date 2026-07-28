<!DOCTYPE html>
<html>
<head>
    <title>Laporan Sarpras Hidayah</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4f46e5; color: white; font-weight: bold; }
        h2 { text-align: center; color: #1e1b4b; margin-bottom: 5px; }
        .text-center { text-align: center; }
        .meta-info { font-size: 10px; color: #666; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>LAPORAN KERUSAKAN SARPRAS FAKULTAS SAINTEK</h2>
    <div class="text-center meta-info">Dicetak pada: {{ date('d-m-Y H:i') }} WIB</div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 20%">Nama Pelapor</th>
                <th style="width: 25%">Lokasi (Lantai & Ruangan)</th>
                <th style="width: 20%">Nama Barang</th>
                <th style="width: 15%">Kerusakan</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $report->user->name }}</td>
                <td>Lantai {{ $report->lantai }} - {{ $report->ruangan }}</td>
                <td>{{ $report->nama_barang }}</td>
                <td>{{ $report->tingkat_kerusakan }}</td>
                <td>{{ $report->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>