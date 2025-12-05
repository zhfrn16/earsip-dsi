@extends('layouts.app2')

@section('title', 'Laporan Surat | e-Arsip DSI')
@section('judul', 'Laporan Surat Masuk & Keluar')

@section('content')
<div class="section-header">
    <h1>📊 Laporan Surat Masuk & Keluar</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item active">Laporan Surat</div>
    </div>
</div>

<div class="section-body">
    <!-- Filter Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-filter"></i> Filter Laporan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.surat.index') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Periode</label>
                                    <select name="periode" id="periode" class="form-control" required>
                                        <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                        <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                        <option value="tahunan" {{ $periode == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                                        <option value="custom" {{ $periode == 'custom' ? 'selected' : '' }}>Custom Range</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Mingguan -->
                            <div class="col-md-2 filter-option" id="filter-mingguan" style="display: {{ $periode == 'mingguan' ? 'block' : 'none' }}">
                                <div class="form-group">
                                    <label>Minggu Ke-</label>
                                    <input type="number" name="minggu" class="form-control" min="1" max="53" value="{{ $minggu ?? date('W') }}">
                                </div>
                            </div>

                            <!-- Filter Bulanan -->
                            <div class="col-md-2 filter-option" id="filter-bulanan" style="display: {{ $periode == 'bulanan' ? 'block' : 'none' }}">
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select name="bulan" class="form-control">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Tahun (untuk mingguan, bulanan, tahunan) -->
                            <div class="col-md-2 filter-option" id="filter-tahun" style="display: {{ in_array($periode, ['mingguan', 'bulanan', 'tahunan']) ? 'block' : 'none' }}">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select name="tahun" class="form-control">
                                        @for($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Filter Custom Range -->
                            <div class="col-md-2 filter-option" id="filter-custom-start" style="display: {{ $periode == 'custom' ? 'block' : 'none' }}">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggal_mulai }}">
                                </div>
                            </div>

                            <div class="col-md-2 filter-option" id="filter-custom-end" style="display: {{ $periode == 'custom' ? 'block' : 'none' }}">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggal_akhir }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Tampilkan
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                                <i class="fas fa-download"></i> Export
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" onclick="exportExcel()">
                                                    <i class="fas fa-file-excel text-success"></i> Export Excel
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="exportPdf()">
                                                    <i class="fas fa-file-pdf text-danger"></i> Export PDF
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Surat</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalKeseluruhan }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Surat Masuk</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalSuratMasuk }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Surat Keluar</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalSuratKeluar }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Rasio</h4>
                    </div>
                    <div class="card-body">
                        {{ $rasio }}:1
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Surat Masuk -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-inbox text-success"></i> Detail Surat Masuk ({{ $totalSuratMasuk }})</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableSuratMasuk">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
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
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $surat->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data surat masuk</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Surat Keluar -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-paper-plane text-warning"></i> Detail Surat Keluar ({{ $totalSuratKeluar }})</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableSuratKeluar">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
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
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $surat->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data surat keluar</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#tableSuratMasuk').DataTable({
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            },
            "pageLength": 10
        });

        $('#tableSuratKeluar').DataTable({
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            },
            "pageLength": 10
        });

        // Handle periode change
        $('#periode').change(function() {
            var periode = $(this).val();

            // Hide all filter options
            $('.filter-option').hide();

            // Show relevant filters
            if (periode === 'mingguan') {
                $('#filter-mingguan').show();
                $('#filter-tahun').show();
            } else if (periode === 'bulanan') {
                $('#filter-bulanan').show();
                $('#filter-tahun').show();
            } else if (periode === 'tahunan') {
                $('#filter-tahun').show();
            } else if (periode === 'custom') {
                $('#filter-custom-start').show();
                $('#filter-custom-end').show();
            }
        });
    });

    function exportExcel() {
        var form = document.getElementById('filterForm');
        var url = new URL('{{ route("laporan.surat.export-excel") }}', window.location.origin);

        // Add form data to URL
        var formData = new FormData(form);
        for (var pair of formData.entries()) {
            url.searchParams.append(pair[0], pair[1]);
        }

        window.location.href = url.toString();
    }

    function exportPdf() {
        var form = document.getElementById('filterForm');
        var url = new URL('{{ route("laporan.surat.export-pdf") }}', window.location.origin);

        // Add form data to URL
        var formData = new FormData(form);
        for (var pair of formData.entries()) {
            url.searchParams.append(pair[0], pair[1]);
        }

        window.location.href = url.toString();
    }
</script>
@endpush

@endsection
