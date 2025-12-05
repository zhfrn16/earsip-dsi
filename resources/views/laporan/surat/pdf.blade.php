<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Surat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .info-box {
            margin: 20px 0;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .info-box table {
            width: 100%;
        }
        .info-box td {
            padding: 5px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table.data-table th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table.data-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .section-title {
            background-color: #333;
            color: white;
            padding: 10px;
            margin-top: 30px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .section-title.masuk {
            background-color: #28a745;
        }
        .section-title.keluar {
            background-color: #ffc107;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-biasa { background-color: #6c757d; color: white; }
        .badge-penting { background-color: #ffc107; color: black; }
        .badge-segera { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN SURAT MASUK & KELUAR</h2>
        <h3>e-Arsip DSI</h3>
        <p>Periode: {{ $periodeText }}</p>
    </div>

    <div class="info-box">
        <table>
            <tr>
                <td width="25%"><strong>Total Surat Masuk</strong></td>
                <td width="25%">: {{ $totalSuratMasuk }}</td>
                <td width="25%"><strong>Total Surat Keluar</strong></td>
                <td width="25%">: {{ $totalSuratKeluar }}</td>
            </tr>
            <tr>
                <td><strong>Total Keseluruhan</strong></td>
                <td>: {{ $totalKeseluruhan }}</td>
                <td><strong>Dicetak</strong></td>
                <td>: {{ date('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <!-- Surat Masuk -->
    <div class="section-title masuk">SURAT MASUK ({{ $totalSuratMasuk }})</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">No Surat</th>
                <th width="20%">Pengirim</th>
                <th width="30%">Perihal</th>
                <th width="10%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratMasuk as $index => $surat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $surat->created_at ? date('d/m/Y', strtotime($surat->created_at)) : '-' }}</td>
                <td>{{ $surat->no_dokumen }}</td>
                <td>{{ $surat->suratMasuk->pengirim_surat }}</td>
                <td>{{ Str::limit($surat->deskripsi, 50) }}</td>
                <td>{{ $surat->kategori->nama_kategori ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data surat masuk</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Surat Keluar -->
    <div class="section-title keluar">SURAT KELUAR ({{ $totalSuratKeluar }})</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">No Surat</th>
                <th width="20%">Tujuan</th>
                <th width="30%">Perihal</th>
                <th width="10%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratKeluar as $index => $surat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $surat->created_at ? date('d/m/Y', strtotime($surat->created_at)) : '-' }}</td>
                <td>{{ $surat->no_dokumen }}</td>
                <td>{{ $surat->suratKeluar->tujuan_surat }}</td>
                <td>{{ Str::limit($surat->deskripsi, 50) }}</td>
                <td> {{ $surat->kategori->nama_kategori ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data surat keluar</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem e-Arsip DSI</p>
    </div>
</body>
</html>
