@extends('layouts.app2')

@section('title', 'Edit Surat Keluar | e-Arsip DSI')
@section('judul', 'Edit Surat Keluar')

@section('content')
<div class="section-header">
    <h1>Edit Surat Keluar</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('surat-keluar.index') }}">Surat Keluar</a></div>
        <div class="breadcrumb-item active">Edit</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Surat Keluar</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('surat-keluar.update', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_surat">No Surat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('no_surat') is-invalid @enderror"
                                           id="no_surat" name="no_surat"
                                           value="{{ old('no_surat', $suratKeluar->no_surat) }}" required>
                                    @error('no_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tgl_surat">Tanggal Surat <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror"
                                           id="tgl_surat" name="tgl_surat"
                                           value="{{ old('tgl_surat', $suratKeluar->tgl_surat ? $suratKeluar->tgl_surat->format('Y-m-d') : '') }}" required>
                                    @error('tgl_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tujuan">Tujuan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror"
                                           id="tujuan" name="tujuan"
                                           value="{{ old('tujuan', $suratKeluar->tujuan) }}" required>
                                    @error('tujuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="menunggu" {{ old('status', $suratKeluar->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                                        @if(auth()->user()->role_id == 1)
                                        <option value="disetujui" {{ old('status', $suratKeluar->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="terkirim" {{ old('status', $suratKeluar->status) == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                                        <option value="ditolak" {{ old('status', $suratKeluar->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        @endif
                                    </select>
                                    @error('status')
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
                                              id="perihal" name="perihal" rows="3" required>{{ old('perihal', $suratKeluar->perihal) }}</textarea>
                                    @error('perihal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file_surat">File Surat</label>
                                    @if($suratKeluar->file_surat)
                                        <div class="mb-2">
                                            <small class="text-muted">File saat ini:</small>
                                            <a href="{{ asset('storage/' . $suratKeluar->file_surat) }}" target="_blank" class="d-block">
                                                <i class="fas fa-file"></i> {{ basename($suratKeluar->file_surat) }}
                                            </a>
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('file_surat') is-invalid @enderror"
                                               id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <label class="custom-file-label" for="file_surat">{{ $suratKeluar->file_surat ? 'Ganti file' : 'Pilih file' }}</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        File yang diizinkan: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 10MB.
                                        @if($suratKeluar->file_surat)
                                            <br>Kosongkan jika tidak ingin mengganti file.
                                        @endif
                                    </small>
                                    @error('file_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                              id="keterangan" name="keterangan" rows="3"
                                              placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $suratKeluar->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->role_id == 1 && ($suratKeluar->status == 'disetujui' || $suratKeluar->status == 'ditolak'))
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="catatan_approval">Catatan Approval</label>
                                    <textarea class="form-control @error('catatan_approval') is-invalid @enderror"
                                              id="catatan_approval" name="catatan_approval" rows="2"
                                              placeholder="Catatan persetujuan atau penolakan">{{ old('catatan_approval', $suratKeluar->catatan_approval) }}</textarea>
                                    @error('catatan_approval')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                    <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">
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

        // Status select with Select2
        $('#status').select2({
            placeholder: "-- Pilih Status --",
            allowClear: false
        });
    });
</script>
@endpush
@endsection
