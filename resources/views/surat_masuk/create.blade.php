@extends('layouts.app2')

@section('title', 'Tambah Surat Masuk | e-Arsip DSI')
@section('judul', 'Tambah Surat Masuk')

@section('content')
<div class="section-header">
    <h1>Tambah Surat Masuk</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('surat-masuk.index') }}">Surat Masuk</a></div>
        <div class="breadcrumb-item active">Tambah</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Surat Masuk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_surat_masuk">ID Surat Masuk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('id_surat_masuk') is-invalid @enderror"
                                           id="id_surat_masuk" name="id_surat_masuk" value="{{ old('id_surat_masuk') }}" required>
                                    @error('id_surat_masuk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="no_surat">No Surat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('no_surat') is-invalid @enderror"
                                           id="no_surat" name="no_surat" value="{{ old('no_surat') }}" required>
                                    @error('no_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                           id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="id_dokumen">Dokumen <span class="text-danger">*</span></label>
                                    <select class="form-control @error('id_dokumen') is-invalid @enderror" id="id_dokumen" name="id_dokumen" required>
                                        <option value="">-- Pilih Dokumen --</option>
                                        @foreach($dokumens as $dokumen)
                                            <option value="{{ $dokumen->id_dokumen }}" {{ old('id_dokumen') == $dokumen->id_dokumen ? 'selected' : '' }}>
                                                {{ $dokumen->no_dokumen ?? $dokumen->id_dokumen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_dokumen')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="id_user">User <span class="text-danger">*</span></label>
                                    <select class="form-control @error('id_user') is-invalid @enderror" id="id_user" name="id_user" required>
                                        <option value="">-- Pilih User --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_user')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pengirim">Pengirim <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('pengirim') is-invalid @enderror"
                                           id="pengirim" name="pengirim" value="{{ old('pengirim') }}" required>
                                    @error('pengirim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sifat_surat">Sifat Surat <span class="text-danger">*</span></label>
                                    <select class="form-control @error('sifat_surat') is-invalid @enderror" id="sifat_surat" name="sifat_surat" required>
                                        <option value="">-- Pilih Sifat Surat --</option>
                                        <option value="Biasa" {{ old('sifat_surat') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                        <option value="Penting" {{ old('sifat_surat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                        <option value="Rahasia" {{ old('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                                        <option value="Segera" {{ old('sifat_surat') == 'Segera' ? 'selected' : '' }}>Segera</option>
                                    </select>
                                    @error('sifat_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="perihal">Perihal <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('perihal') is-invalid @enderror"
                                              id="perihal" name="perihal" rows="3" required>{{ old('perihal') }}</textarea>
                                    @error('perihal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file">File Surat</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                               id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="file">Pilih file</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        File yang diizinkan: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 10MB.
                                    </small>
                                    @error('file')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="isi_surat">Isi Surat</label>
                                    <textarea class="form-control @error('isi_surat') is-invalid @enderror"
                                              id="isi_surat" name="isi_surat" rows="4"
                                              placeholder="Ringkasan isi surat (opsional)">{{ old('isi_surat') }}</textarea>
                                    @error('isi_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                    <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">
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
        });

        // Select2 for dropdowns
        $('#id_dokumen, #id_user, #sifat_surat').select2({
            placeholder: function() {
                return $(this).find('option:first').text();
            },
            allowClear: false
        });
    });
</script>
@endpush
@endsection
