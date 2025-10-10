@extends('layouts.app2')

@section('title', 'Tambah Kategori | e-Arsip DSI')
@section('judul', 'Tambah Kategori')

@section('content')
<div class="section-header">
    <h1>Tambah Kategori</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Kategori</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenisDokumen.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="id_kategori">ID Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('id_kategori') is-invalid @enderror"
                                   id="id_kategori" name="id_kategori" value="{{ old('id_kategori') }}"
                                   maxlength="5" required>
                            <small class="form-text text-muted">Maksimal 5 karakter</small>
                            @error('id_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                   id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                            @error('nama_kategori')
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
                            <a href="{{ route('jenisDokumen.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
