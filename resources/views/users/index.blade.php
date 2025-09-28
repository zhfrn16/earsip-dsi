@extends('layouts.app2')

@section('title', 'User Management | e-Arsip DSI')
@section('judul', 'User Management')

@section('content')
<div class="section-header">
    <h1>Data Users</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item active">Users</div>
    </div>
    @if(auth()->user()->id_role == 1)
    <div class="section-header-button">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>
    @endif
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
                    <h4>Daftar Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="users-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    @if(auth()->user()->id_role == 1)
                                    <th width="15%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($user->foto)
                                            <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->nama_lengkap }}"
                                                 class="rounded-circle" width="40" height="40">
                                        @else
                                            <div class="avatar avatar-md bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                                {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $user->nama_lengkap }}</strong>
                                        @if($user->id_user == auth()->user()->id_user)
                                            <span class="badge badge-info">
                                                <i class="fas fa-user"></i> You
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <code>{{ $user->username }}</code>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role)
                                            @if($user->id_role == 1)
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-crown"></i> {{ $user->role->nama_role }}
                                                </span>
                                            @elseif($user->id_role == 2)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-user"></i> {{ $user->role->nama_role }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-question"></i> {{ $user->role->nama_role }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exclamation"></i> No Role
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Verified
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Unverified
                                            </span>
                                        @endif
                                    </td>
                                    @if(auth()->user()->id_role == 1)
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info" title="Detail"
                                                    data-toggle="modal" data-target="#detailModal-{{ $user->id_user }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($user->id_user != auth()->user()->id_user)
                                            <a href="{{ route('users.edit', $user->id_user) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="confirmDelete('{{ $user->id_user }}', '{{ $user->nama_lengkap }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @else
                                            <a href="{{ route('profile.show') }}"
                                               class="btn btn-sm btn-primary" title="Profile">
                                                <i class="fas fa-user-cog"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal-{{ $user->id_user }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail User</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 text-center">
                                                        @if($user->foto)
                                                            <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->nama_lengkap }}"
                                                                 class="rounded-circle mb-3" width="120" height="120">
                                                        @else
                                                            <div class="avatar avatar-xl bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 120px; height: 120px; font-size: 2rem;">
                                                                {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                        <h5>{{ $user->nama_lengkap }}</h5>
                                                        <p class="text-muted">{{ $user->role->nama_role ?? 'No Role' }}</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <td width="40%"><strong>ID User</strong></td>
                                                                <td>: {{ $user->id_user }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Username</strong></td>
                                                                <td>: <code>{{ $user->username }}</code></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Email</strong></td>
                                                                <td>: {{ $user->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Email Verified</strong></td>
                                                                <td>:
                                                                    @if($user->email_verified_at)
                                                                        <span class="badge badge-success">Yes</span>
                                                                        <small class="text-muted">({{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y H:i') }})</small>
                                                                    @else
                                                                        <span class="badge badge-warning">No</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Created At</strong></td>
                                                                <td>: {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Updated At</strong></td>
                                                                <td>: {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                @if($user->id_user != auth()->user()->id_user)
                                                <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i> Edit User
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->id_role == 1 ? '8' : '7' }}" class="text-center">Tidak ada data user</td>
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
        $('#users-table').DataTable({
            responsive: true,
            language: {
                "decimal": "",
                "emptyTable": "Tidak ada data user",
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
            order: [[2, 'asc']]
        });
    });

    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus user "' + nama + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').action = '/users/' + id;
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endpush
@endsection
