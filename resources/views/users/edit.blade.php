@extends('layouts.app2')

@section('title', 'Edit User | e-Arsip DSI')
@section('judul', 'Edit User')

@section('content')
<div class="section-header">
    <h1>Edit User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></div>
        <div class="breadcrumb-item active">Edit</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit User - {{ $user->nama_lengkap }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id_user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           id="nama_lengkap" name="nama_lengkap"
                                           value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                           id="username" name="username"
                                           value="{{ old('username', $user->username) }}" required>
                                    <small class="form-text text-muted">
                                        Username akan digunakan untuk login (tanpa spasi, karakter khusus diperbolehkan: _, -, .)
                                    </small>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email"
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="id_role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('id_role') is-invalid @enderror" id="id_role" name="id_role" required>
                                        <option value="">-- Pilih Role --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id_role }}"
                                                {{ old('id_role', $user->id_role) == $role->id_role ? 'selected' : '' }}>
                                                {{ $role->nama_role }}
                                                @if($role->id_role == 1)
                                                    (Administrator)
                                                @elseif($role->id_role == 2)
                                                    (Staff)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                                <i class="fas fa-eye" id="password-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Kosongkan jika tidak ingin mengubah password. Password minimal 6 karakter.
                                    </small>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation" name="password_confirmation">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="foto">Foto Profile</label>
                                    @if($user->foto)
                                        <div class="mb-2">
                                            <small class="text-muted">Foto saat ini:</small>
                                            <div class="d-block">
                                                <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->nama_lengkap }}"
                                                     class="rounded-circle" width="80" height="80">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror"
                                               id="foto" name="foto" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <label class="custom-file-label" for="foto">{{ $user->foto ? 'Ganti foto' : 'Pilih foto' }}</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        File yang diizinkan: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                                        @if($user->foto)
                                            <br>Kosongkan jika tidak ingin mengganti foto.
                                        @endif
                                    </small>
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Preview foto baru -->
                                <div class="form-group" id="foto-preview" style="display: none;">
                                    <label>Preview Foto Baru:</label>
                                    <div class="text-center">
                                        <img id="foto-preview-img" src="" alt="Preview" class="rounded-circle" width="120" height="120">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" value="1"
                                            {{ $user->email_verified_at ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_verified">
                                            Email terverifikasi
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Status verifikasi email saat ini:
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Terverifikasi pada {{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span class="badge badge-warning">Belum terverifikasi</span>
                                        @endif
                                    </small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // File input custom label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);

            // Preview foto
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#foto-preview-img').attr('src', e.target.result);
                    $('#foto-preview').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Select2 for role dropdown
        $('#id_role').select2({
            placeholder: "-- Pilih Role --",
            allowClear: false
        });
    });

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(fieldId + '-eye');

        if (field.type === 'password') {
            field.type = 'text';
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection
