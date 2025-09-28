@extends('layouts.app2')

@section('title', 'Tambah Dokumen | e-Arsip DSI')
@section('judul', 'Tambah Dokumen')

@section('content')
<div class="section-header">
    <h1>Tambah Dokumen</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('dataArsip.index') }}">Dokumen</a></div>
        <div class="breadcrumb-item active">Tambah</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Dokumen</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dataArsip.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="id_dokumen">ID Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('id_dokumen') is-invalid @enderror"
                                   id="id_dokumen" name="id_dokumen" value="{{ old('id_dokumen') }}" required>
                            @error('id_dokumen')
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
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
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
                            <a href="{{ route('dataArsip.index') }}" class="btn btn-secondary">
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
<script>
    $(document).ready(function() {
        $('#id_kategori').select2({
            placeholder: "-- Pilih Kategori --",
            allowClear: true
        });
    });
</script>
@endpush
@endsection
