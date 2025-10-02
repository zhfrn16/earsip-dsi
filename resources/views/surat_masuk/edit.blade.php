@extends('layouts.app2')

@section('title', 'Edit Surat Masuk | e-Arsip DSI')
@section('judul', 'Edit Surat Masuk')

@section('content')
<div class="section-header">
    <h1>Edit Surat Masuk</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('surat-masuk.index') }}">Surat Masuk</a></div>
        <div class="breadcrumb-item active">Edit</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Surat Masuk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('surat-masuk.update', $suratMasuk->id_surat_masuk) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_surat">No Surat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('no_surat') is-invalid @enderror"
                                           id="no_surat" name="no_surat"
                                           value="{{ old('no_surat', $suratMasuk->no_surat) }}" required>
                                    @error('no_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                           id="tanggal" name="tanggal"
                                           value="{{ old('tanggal', $suratMasuk->tanggal ? $suratMasuk->tanggal->format('Y-m-d') : '') }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="pengirim">Pengirim <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('pengirim') is-invalid @enderror"
                                           id="pengirim" name="pengirim"
                                           value="{{ old('pengirim', $suratMasuk->pengirim) }}" required>
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
                                        <option value="Biasa" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                        <option value="Penting" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'Penting' ? 'selected' : '' }}>Penting</option>
                                        <option value="Rahasia" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                                        <option value="Segera" {{ old('sifat_surat', $suratMasuk->sifat_surat) == 'Segera' ? 'selected' : '' }}>Segera</option>
                                    </select>
                                    @error('sifat_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="perihal">Perihal <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('perihal') is-invalid @enderror"
                                              id="perihal" name="perihal" rows="3" required>{{ old('perihal', $suratMasuk->perihal) }}</textarea>
                                    @error('perihal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file">File Surat</label>
                                    @if($suratMasuk->file)
                                        <div class="mb-2">
                                            <small class="text-muted">File saat ini:</small>
                                            <a href="{{ asset('file_arsip/' . $suratMasuk->file) }}" target="_blank" class="d-block">
                                                <i class="fas fa-file"></i> {{ basename($suratMasuk->file) }}
                                            </a>
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                               id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                               onchange="updateFileName(this)">
                                        <label class="custom-file-label" for="file" id="file-label">{{ $suratMasuk->file ? 'Ganti file' : 'Pilih file' }}</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        File yang diizinkan: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 10MB.
                                        @if($suratMasuk->file)
                                            <br>Kosongkan jika tidak ingin mengganti file.
                                        @endif
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
                                              id="isi_surat" name="isi_surat" rows="3"
                                              placeholder="Isi surat (opsional)">{{ old('isi_surat', $suratMasuk->isi_surat) }}</textarea>
                                    @error('isi_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update
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
<style>
    /* Fix for custom-file Bootstrap component */
    .custom-file-label.selected {
        color: #495057;
    }
    .custom-file-input:focus ~ .custom-file-label {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
<script>
    // Simple vanilla JavaScript function
    function updateFileName(input) {
        console.log('updateFileName called');
        const fileName = input.files.length > 0 ? input.files[0].name : 'Pilih file';
        console.log('Selected file:', fileName);

        const label = document.getElementById('file-label');
        if (label) {
            label.textContent = fileName;
            label.classList.add('selected');
            console.log('Label updated to:', fileName);
        }
    }

    $(document).ready(function() {
        // File input custom label - Enhanced version
        $(document).on('change', '.custom-file-input', function() {
            console.log('File input changed - Enhanced');

            // Get filename
            let fileName = 'Pilih file';
            if (this.files && this.files.length > 0) {
                fileName = this.files[0].name;
            } else {
                let fullPath = $(this).val();
                if (fullPath) {
                    fileName = fullPath.replace(/C:\\fakepath\\/i, '');
                }
            }

            console.log('Selected file:', fileName);

            // Update label
            const label = $(this).siblings('.custom-file-label');
            label.addClass("selected").html(fileName);

            console.log('Label updated to:', fileName);
        });

        // Status select with Select2
        $('#status').select2({
            placeholder: "-- Pilih Status --",
            allowClear: false
        });
    });
</script>
@endpush
@endsection
