<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-size: 16px; font-weight: bold;">
                LAPORAN SURAT MASUK DAN KELUAR
            </th>
        </tr>
        <tr>
            <th colspan="7" style="text-align: center; font-size: 14px;">
                Periode: {{ $periodeText }}
            </th>
        </tr>
        <tr><th colspan="7"></th></tr>
        <tr>
            <th colspan="2" style="font-weight: bold;">Total Surat Masuk:</th>
            <th>{{ $totalSuratMasuk }}</th>
            <th></th>
            <th colspan="2" style="font-weight: bold;">Total Surat Keluar:</th>
            <th>{{ $totalSuratKeluar }}</th>
        </tr>
        <tr><th colspan="7"></th></tr>
    </thead>
</table>

<table>
    <thead>
        <tr>
            <th colspan="7" style="background-color: #28a745; color: white; font-weight: bold; text-align: center;">
                SURAT MASUK
            </th>
        </tr>
        <tr style="background-color: #cccccc; font-weight: bold;">
            <th>No</th>
            <th>Tanggal</th>
            <th>No Surat</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Kategori</th>
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

<table>
    <thead>
        <tr><th colspan="7"></th></tr>
        <tr><th colspan="7"></th></tr>
        <tr>
            <th colspan="7" style="background-color: #ffc107; color: white; font-weight: bold; text-align: center;">
                SURAT KELUAR
            </th>
        </tr>
        <tr style="background-color: #cccccc; font-weight: bold;">
            <th>No</th>
            <th>Tanggal</th>
            <th>No Surat</th>
            <th>Tujuan</th>
            <th>Perihal</th>
            <th>Kategori</th>
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
            <td>{{ $surat->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center;">Tidak ada data surat keluar</td>
        </tr>
        @endforelse
    </tbody>
</table>

<table>
    <thead>
        <tr><th colspan="7"></th></tr>
        <tr>
            <th colspan="7" style="text-align: right; font-style: italic; font-size: 10px;">
                Dicetak pada: {{ date('d/m/Y H:i:s') }}
            </th>
        </tr>
    </thead>
</table>
