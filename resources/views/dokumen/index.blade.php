@extends('layouts.app2')

@section('title', 'Dokumen | e-Arsip DSI')
@section('judul', 'Dokumen')

@section('content')
<div class="section-header">
    <h1>Dokumen</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Dokumen</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Dokumen</h4>
                    <div class="card-header-action">
                        <a href="{{ route('dataArsip.create') }}" class="btn btn-primary">
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

                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Dokumen</th>
                                    <th>No Dokumen</th>
                                    <th>Tahun</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $index => $dokumen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $dokumen->id_dokumen }}</td>
                                    <td>{{ $dokumen->no_dokumen }}</td>
                                    <td>{{ $dokumen->tahun }}</td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $dokumen->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($dokumen->deskripsi ?? '-', 50) }}</td>
                                    <td>
                                        <a href="{{ route('dataArsip.edit', $dokumen->id_dokumen) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('dataArsip.destroy', $dokumen->id_dokumen) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data dokumen</td>
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
        $('#table-1').DataTable({
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection
