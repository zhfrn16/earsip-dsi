@extends('layouts.app2')

@section('title', 'Tambah Dokumen | e-Arsip DSI')
@section('judul', 'Tambah Dokumen')

@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Dokumen</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>ID Dokumen:</strong> <code>{{ $nextId ?? 'DOK##' }}</code> <small class="text-muted">(akan dibuat otomatis)</small>
                        </div>

                        <div class="form-group">
                            <label for="nama_dokumen">Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror"
                                   id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen') }}" required>
                            @error('nama_dokumen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_dokumen">No Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_dokumen') is-invalid @enderror"
                                   id="no_dokumen" name="no_dokumen" value="{{ old('no_dokumen') }}" required>
                            @error('no_dokumen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                   id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}"
                                   min="1900" max="{{ date('Y') + 10 }}" required>
                            @error('tahun')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @if(isset($kategoris) && $kategoris->count() > 0)
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('id_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_surat">Jenis Surat</label>
                            <select class="form-control @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat">
                                <option value="">-- Pilih Jenis Surat --</option>
                                <option value="surat_masuk" {{ old('jenis_surat') == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                <option value="surat_keluar" {{ old('jenis_surat') == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                            </select>
                            @error('jenis_surat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group" id="pengirim_group" style="display: none;">
                            <label for="pengirim_surat">Pengirim Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pengirim_surat') is-invalid @enderror"
                                   id="pengirim_surat" name="pengirim_surat" value="{{ old('pengirim_surat') }}">
                            @error('pengirim_surat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group" id="tujuan_group" style="display: none;">
                            <label for="tujuan_surat">Tujuan Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tujuan_surat') is-invalid @enderror"
                                   id="tujuan_surat" name="tujuan_surat" value="{{ old('tujuan_surat') }}">
                            @error('tujuan_surat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file">File Dokumen</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                       id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <label class="custom-file-label" for="file">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Format yang diizinkan: PDF. Maksimal 10MB.</small>
                            @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Ensure jQuery and Select2 are loaded before this script -->
<script>
    $(document).ready(function() {
        if (typeof $.fn.select2 === 'undefined') {
            console.error('Select2 is not loaded. Please include Select2 JS and CSS.');
        } else {
            $('#id_kategori').select2({
                placeholder: "-- Pilih Kategori --",
                allowClear: true
            });
        }

        // Handle jenis surat change
        $('#jenis_surat').change(function() {
            console.log('Jenis surat changed:', $(this).val());
            var jenisSurat = $(this).val();

            if (jenisSurat === 'surat_masuk') {
                $('#pengirim_group').show();
                $('#tujuan_group').hide();
                $('#pengirim_surat').attr('required', true);
                $('#tujuan_surat').attr('required', false);
            } else if (jenisSurat === 'surat_keluar') {
                $('#pengirim_group').hide();
                $('#tujuan_group').show();
                $('#pengirim_surat').attr('required', false);
                $('#tujuan_surat').attr('required', true);
            } else {
                $('#pengirim_group').hide();
                $('#tujuan_group').hide();
                $('#pengirim_surat').attr('required', false);
                $('#tujuan_surat').attr('required', false);
            }
        });

        // Trigger change event on page load to handle old values
        $('#jenis_surat').trigger('change');

        // Handle custom file input label
        $('#file').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName || 'Pilih file...');
        });
    });
</script>
@endpush
@endsection
