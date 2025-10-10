@extends('layouts.app2')

@section('title', 'Edit Kategori | e-Arsip DSI')
@section('judul', 'Edit Kategori')

@section('content')
<div class="section-header">
    <h1>Edit Kategori</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Kategori</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenisDokumen.update', $kategori->id_kategori) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="id_kategori">ID Kategori</label>
                            <input type="text" class="form-control" id="id_kategori" value="{{ $kategori->id_kategori }}" disabled>
                            <small class="form-text text-muted">ID Kategori tidak dapat diubah</small>
                        </div>

                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                   id="nama_kategori" name="nama_kategori"
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
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
