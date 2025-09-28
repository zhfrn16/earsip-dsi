@extends('layouts.app2')

@section('title', 'Tambah User | e-Arsip DSI')
@section('judul', 'Tambah User')

@section('content')
<div class="section-header">
    <h1>Tambah User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></div>
        <div class="breadcrumb-item active">Tambah</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                           id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                           id="username" name="username" value="{{ old('username') }}" required>
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
                                           id="email" name="email" value="{{ old('email') }}" required>
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
                                            <option value="{{ $role->id_role }}" {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
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
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                                <i class="fas fa-eye" id="password-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Password minimal 6 karakter
                                    </small>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation" name="password_confirmation" required>
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
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror"
                                               id="foto" name="foto" accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <label class="custom-file-label" for="foto">Pilih foto</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        File yang diizinkan: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                                    </small>
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Preview foto -->
                                <div class="form-group" id="foto-preview" style="display: none;">
                                    <label>Preview Foto:</label>
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
                                        <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_verified">
                                            Tandai email sebagai terverifikasi
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Jika dicentang, user tidak perlu melakukan verifikasi email.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
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

        // Auto generate username from nama_lengkap
        $('#nama_lengkap').on('input', function() {
            let nama = $(this).val();
            let username = nama.toLowerCase()
                              .replace(/\s+/g, '_')
                              .replace(/[^a-z0-9_-]/g, '');
            $('#username').val(username);
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
