@extends('layouts.app2')

@section('title', 'Surat Masuk | e-Arsip DSI')
@section('judul', 'Surat Masuk')

@section('content')
<div class="section-header">
    <h1>Data Surat Masuk</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item active">Surat Masuk</div>
    </div>
    <div class="section-header-button">
        <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Surat Masuk
        </a>
    </div>
</div>

<div class="section-body">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Surat Masuk</h4>
                    <div class="card-header-action">
                        <div class="btn-group">
                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fas fa-file-excel"></i> Export
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('surat-masuk.export') }}">Export Excel</a>
                                <a class="dropdown-item" href="{{ route('surat-masuk.export-pdf') }}">Export PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="surat-masuk-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>No Surat</th>
                                    <th>Tgl Terima</th>
                                    <th>Tgl Surat</th>
                                    <th>Pengirim</th>
                                    <th>Perihal</th>
                                    <th>Disposisi</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suratMasuk as $surat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $surat->no_surat }}</strong>
                                    </td>
                                    <td>{{ $surat->tgl_terima ? \Carbon\Carbon::parse($surat->tgl_terima)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $surat->tgl_surat ? \Carbon\Carbon::parse($surat->tgl_surat)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $surat->pengirim }}</td>
                                    <td>
                                        <span title="{{ $surat->perihal }}">
                                            {{ Str::limit($surat->perihal, 50) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($surat->disposisi)
                                            <span class="badge badge-info">
                                                <i class="fas fa-share"></i> Ada
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-minus"></i> Belum
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($surat->status == 'selesai')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @elseif($surat->status == 'proses')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Proses
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-inbox"></i> Diterima
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info" title="Detail"
                                                    data-toggle="modal" data-target="#detailModal-{{ $surat->id_surat_masuk }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('surat-masuk.edit', $surat->id_surat_masuk) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="confirmDelete('{{ $surat->id_surat_masuk }}', '{{ $surat->no_surat }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal-{{ $surat->id_surat_masuk }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Surat Masuk</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td width="40%"><strong>No Surat</strong></td>
                                                                <td>: {{ $surat->no_surat }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tanggal Terima</strong></td>
                                                                <td>: {{ $surat->tgl_terima ? \Carbon\Carbon::parse($surat->tgl_terima)->format('d/m/Y') : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Tanggal Surat</strong></td>
                                                                <td>: {{ $surat->tgl_surat ? \Carbon\Carbon::parse($surat->tgl_surat)->format('d/m/Y') : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Pengirim</strong></td>
                                                                <td>: {{ $surat->pengirim }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td width="40%"><strong>Status</strong></td>
                                                                <td>:
                                                                    @if($surat->status == 'selesai')
                                                                        <span class="badge badge-success">Selesai</span>
                                                                    @elseif($surat->status == 'proses')
                                                                        <span class="badge badge-warning">Proses</span>
                                                                    @else
                                                                        <span class="badge badge-secondary">Diterima</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Disposisi</strong></td>
                                                                <td>:
                                                                    @if($surat->disposisi)
                                                                        <span class="badge badge-info">Ada</span>
                                                                    @else
                                                                        <span class="badge badge-secondary">Belum</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <strong>Perihal:</strong>
                                                        <p class="mt-2">{{ $surat->perihal }}</p>
                                                    </div>
                                                    @if($surat->keterangan)
                                                    <div class="col-12">
                                                        <strong>Keterangan:</strong>
                                                        <p class="mt-2">{{ $surat->keterangan }}</p>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data surat masuk</td>
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

<!-- Delete Form -->
<form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#surat-masuk-table').DataTable({
            responsive: true,
            language: {
                "decimal": "",
                "emptyTable": "Tidak ada data surat masuk",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Tampilkan _MENU_ data",
                "loadingRecords": "Loading...",
                "processing": "Processing...",
                "search": "Cari:",
                "zeroRecords": "Tidak ada data yang cocok",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            order: [[2, 'desc']]
        });
    });

    function confirmDelete(id, noSurat) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus surat masuk "' + noSurat + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').action = '/surat-masuk/' + id;
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endpush
@endsection
