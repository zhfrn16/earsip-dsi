@extends('layouts.app2')

@section('title', 'Detail User | e-Arsip DSI')
@section('judul', 'Detail User')

@section('content')
<div class="section-header">
    <h1>Detail User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></div>
        <div class="breadcrumb-item active">Detail</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi User</h4>
                    <div class="card-header-action">
                        <div class="btn-group">
                            @if($user->id_user != auth()->user()->id_user || auth()->user()->id_role == 1)
                            <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @endif
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" style="width: 40%;">ID User</td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge badge-secondary p-2">{{ $user->id_user }}</span>
                                        @if($user->id_user == auth()->user()->id_user)
                                            <span class="badge badge-info ml-1">
                                                <i class="fas fa-user"></i> You
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Lengkap</td>
                                    <td>:</td>
                                    <td><strong>{{ $user->nama_lengkap }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Username</td>
                                    <td>:</td>
                                    <td><code>{{ $user->username }}</code></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email</td>
                                    <td>:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" style="width: 40%;">Role</td>
                                    <td>:</td>
                                    <td>
                                        @if($user->role)
                                            @if($user->id_role == 1)
                                                <span class="badge badge-danger p-2">
                                                    <i class="fas fa-crown"></i> {{ $user->role->nama_role }}
                                                </span>
                                            @elseif($user->id_role == 2)
                                                <span class="badge badge-success p-2">
                                                    <i class="fas fa-user"></i> {{ $user->role->nama_role }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary p-2">
                                                    <i class="fas fa-question"></i> {{ $user->role->nama_role }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge badge-warning p-2">
                                                <i class="fas fa-exclamation"></i> No Role
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Email</td>
                                    <td>:</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success p-2">
                                                <i class="fas fa-check-circle"></i> Verified
                                            </span>
                                            <br>
                                            <small class="text-muted">{{ $user->email_verified_at->format('d M Y H:i') }}</small>
                                        @else
                                            <span class="badge badge-warning p-2">
                                                <i class="fas fa-clock"></i> Unverified
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">Dibuat</td>
                                    <td>:</td>
                                    <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                                </tr>
                                @if($user->created_at != $user->updated_at)
                                <tr>
                                    <td class="font-weight-bold">Diperbarui</td>
                                    <td>:</td>
                                    <td>{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <!-- User Photo Card -->
            <div class="card">
                <div class="card-header">
                    <h4>Foto Profile</h4>
                </div>
                <div class="card-body text-center">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->nama_lengkap }}"
                             class="rounded-circle img-fluid mb-3"
                             style="max-width: 200px; max-height: 200px; width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="avatar avatar-xl bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3 mx-auto"
                             style="width: 200px; height: 200px; font-size: 4rem;">
                            {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="mb-0">{{ $user->nama_lengkap }}</h5>
                    <p class="text-muted">{{ $user->role->nama_role ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Role Info Card -->
            @if($user->role)
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Role</h4>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold text-primary">{{ $user->role->nama_role }}</h6>
                    @if($user->role->deskripsi ?? null)
                        <p class="text-muted small mb-0">{{ $user->role->deskripsi }}</p>
                    @else
                        <p class="text-muted small mb-0">
                            @if($user->id_role == 1)
                                Administrator dengan akses penuh ke sistem
                            @elseif($user->id_role == 2)
                                User dengan akses terbatas
                            @endif
                        </p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Security Info Card -->
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Keamanan</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Password:</span>
                        <span class="badge badge-success">
                            <i class="fas fa-lock"></i> Terenkripsi
                        </span>
                    </div>

                    @if($user->id_user != auth()->user()->id_user && auth()->user()->id_role == 1)
                    <hr>
                    <div class="text-center">
                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDelete('{{ $user->id_user }}', '{{ $user->nama_lengkap }}')">
                            <i class="fas fa-trash"></i> Hapus User
                        </button>
                    </div>
                    @endif
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
