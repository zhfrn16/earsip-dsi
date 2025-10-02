@extends('layouts.app2')

@section('title', 'Dokumen | e-Arsip DSI')
@section('judul', 'Dokumen')

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Dokumen</h4>
                    <div class="card-header-action">
                        <a href="{{ route('dokumen.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Dokumen
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="GET" action="{{ route('dokumen.index') }}" class="form-inline flex-wrap">
                                <div class="form-group mb-2 mr-3">
                                    <input type="text" class="form-control" name="search"
                                           value="{{ request('search') }}"
                                           placeholder="Cari dokumen..." style="width: 250px;">
                                </div>

                                <div class="form-group mb-2 mr-3">
                                    <select name="kategori" class="form-control" style="width: 200px;">
                                        <option value="">-- Semua Kategori --</option>
                                        @if(isset($kategoris) && $kategoris->count() > 0)
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id_kategori }}"
                                                    {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-2 mr-3">
                                    <select name="jenis_surat" class="form-control" style="width: 150px;">
                                        <option value="">-- Semua Jenis --</option>
                                        <option value="surat_masuk" {{ request('jenis_surat') == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                        <option value="surat_keluar" {{ request('jenis_surat') == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                                    </select>
                                </div>

                                <div class="form-group mb-2 mr-3">
                                    <select name="tahun" class="form-control" style="width: 120px;">
                                        <option value="">-- Semua Tahun --</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mb-2 mr-2">
                                    <i class="fas fa-search"></i> Cari
                                </button>

                                <a href="{{ route('dokumen.index') }}" class="btn btn-secondary mb-2">
                                    <i class="fas fa-refresh"></i> Reset
                                </a>
                            </form>
                        </div>
                    </div>

                    <!-- Results Summary -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Menampilkan <strong>{{ $dokumens->count() }}</strong> dokumen
                                @if(request()->hasAny(['search', 'kategori', 'jenis_surat', 'tahun']))
                                    dari hasil pencarian/filter
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Dokumen</th>
                                    <th>Nama Dokumen</th>
                                    <th>No Dokumen</th>
                                    <th>Tahun</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>File</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $index => $dokumen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $dokumen->id_dokumen }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $dokumen->nama_dokumen }}</strong>
                                        @if($dokumen->suratMasuk)
                                            <br><small class="text-muted">Dari: {{ $dokumen->suratMasuk->pengirim_surat }}</small>
                                        @elseif($dokumen->suratKeluar)
                                            <br><small class="text-muted">Untuk: {{ $dokumen->suratKeluar->tujuan_surat }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $dokumen->no_dokumen }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $dokumen->tahun }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $dokumen->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($dokumen->jenis_surat == 'surat_masuk')
                                            <span class="badge badge-success">Surat Masuk</span>
                                        @elseif($dokumen->jenis_surat == 'surat_keluar')
                                            <span class="badge badge-warning">Surat Keluar</span>
                                        @else
                                            <span class="badge badge-secondary">Dokumen Umum</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($dokumen->file)
                                            <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}"
                                               class="btn btn-sm btn-outline-primary" title="Download File">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($dokumen->deskripsi ?? '-', 40) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dokumen.show', $dokumen->id_dokumen) }}"
                                               class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dokumen.destroy', $dokumen->id_dokumen) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Tidak ada dokumen ditemukan</h5>
                                            @if(request()->hasAny(['search', 'kategori', 'jenis_surat', 'tahun']))
                                                <p class="text-muted">Coba ubah kriteria pencarian atau <a href="{{ route('dokumen.index') }}">reset filter</a></p>
                                            @else
                                                <p class="text-muted">Belum ada dokumen yang ditambahkan</p>
                                            @endif
                                        </div>
                                    </td>
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
        // Initialize DataTable with custom settings
        $('#table-1').DataTable({
            "responsive": true,
            "ordering": true,
            "searching": false, // Disable built-in search since we have custom search
            "pageLength": 25,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": [7, 9] }, // Disable sorting for File and Action columns
                { "className": "text-center", "targets": [0, 4, 6, 7] } // Center align specific columns
            ]
        });

        // Auto-submit form when filter dropdowns change
        $('select[name="kategori"], select[name="jenis_surat"], select[name="tahun"]').change(function() {
            $(this).closest('form').submit();
        });

        // Clear search input when reset button is clicked
        $('.btn-secondary').click(function(e) {
            if ($(this).attr('href').includes('dokumen')) {
                e.preventDefault();
                $('input[name="search"]').val('');
                $('select[name="kategori"]').val('');
                $('select[name="jenis_surat"]').val('');
                $('select[name="tahun"]').val('');
                window.location.href = $(this).attr('href');
            }
        });

        // Add keyboard shortcut for search (Ctrl+F or Cmd+F)
        $(document).keydown(function(e) {
            if ((e.ctrlKey || e.metaKey) && e.keyCode == 70) {
                e.preventDefault();
                $('input[name="search"]').focus().select();
            }
        });

        // Tooltip initialization for action buttons
        $('[title]').tooltip();
    });
</script>
@endpush
@endsection
