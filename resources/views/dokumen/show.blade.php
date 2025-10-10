@extends('layouts.app2')

@section('title', 'Detail Dokumen | e-Arsip DSI')
@section('judul', 'Detail Dokumen')

@section('content')
<div class="section-header">
    <h1>Detail Dokumen</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Dokumen</h4>
                    <div class="card-header-action">
                        <div class="btn-group">
                            <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if($dokumen->file)
                                <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Download File
                                </a>
                            @endif
                            <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">
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
                                    <td class="font-weight-bold" style="width: 40%;">ID Dokumen</td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge badge-secondary p-2">{{ $dokumen->id_dokumen }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Dokumen</td>
                                    <td>:</td>
                                    <td><strong>{{ $dokumen->nama_dokumen }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">No Surat</td>
                                    <td>:</td>
                                    <td>{{ $dokumen->no_dokumen }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tahun</td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge badge-info">{{ $dokumen->tahun }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Kategori</td>
                                    <td>:</td>
                                    <td>
                                        <span class="badge badge-primary p-2">
                                            {{ $dokumen->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" style="width: 40%;">Jenis Surat</td>
                                    <td>:</td>
                                    <td>
                                        @if($dokumen->jenis_surat == 'surat_masuk')
                                            <span class="badge badge-success p-2">Surat Masuk</span>
                                        @elseif($dokumen->jenis_surat == 'surat_keluar')
                                            <span class="badge badge-warning p-2">Surat Keluar</span>
                                        @else
                                            <span class="badge badge-secondary p-2">Dokumen Umum</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($dokumen->suratMasuk)
                                <tr>
                                    <td class="font-weight-bold">Pengirim</td>
                                    <td>:</td>
                                    <td>{{ $dokumen->suratMasuk->pengirim_surat }}</td>
                                </tr>
                                @elseif($dokumen->suratKeluar)
                                <tr>
                                    <td class="font-weight-bold">Tujuan</td>
                                    <td>:</td>
                                    <td>{{ $dokumen->suratKeluar->tujuan_surat }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="font-weight-bold">File</td>
                                    <td>:</td>
                                    <td>
                                        @if($dokumen->file)
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-alt text-primary mr-2"></i>
                                                <div>
                                                    <div>{{ basename($dokumen->file) }}</div>
                                                    @if(Storage::disk('public')->exists($dokumen->file))
                                                        <small class="text-muted">{{ formatBytes(Storage::disk('public')->size($dokumen->file)) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Dibuat</td>
                                    <td>:</td>
                                    <td>{{ $dokumen->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Diperbarui</td>
                                    <td>:</td>
                                    <td>{{ $dokumen->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <!-- File Preview Card -->
            @if($dokumen->file)
            <div class="card">
                <div class="card-header">
                    <h4>Preview File</h4>
                </div>
                <div class="card-body text-center">
                    @php
                        $fileExtension = strtolower(pathinfo($dokumen->file, PATHINFO_EXTENSION));
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                        $isImage = in_array($fileExtension, $imageExtensions);
                    @endphp

                    @if($isImage)
                        <img src="{{ $dokumen->file_url }}"
                             alt="{{ $dokumen->nama_dokumen }}"
                             class="img-fluid rounded mb-3"
                             style="max-height: 300px;">
                    @else
                        <div class="mb-3">
                            @if($fileExtension == 'pdf')
                                <i class="fas fa-file-pdf fa-5x text-danger"></i>
                            @elseif(in_array($fileExtension, ['doc', 'docx']))
                                <i class="fas fa-file-word fa-5x text-primary"></i>
                            @elseif(in_array($fileExtension, ['xls', 'xlsx']))
                                <i class="fas fa-file-excel fa-5x text-success"></i>
                            @else
                                <i class="fas fa-file-alt fa-5x text-secondary"></i>
                            @endif
                        </div>
                        <p class="text-muted">{{ strtoupper($fileExtension) }} File</p>
                    @endif

                    <div class="btn-group w-100">
                        <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}"
                           class="btn btn-primary">
                            <i class="fas fa-download"></i> Download
                        </a>
                        @if(!$isImage && $fileExtension == 'pdf')
                        <a href="{{ $dokumen->file_url }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-external-link-alt"></i> Buka
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Category Info Card -->
            @if($dokumen->kategori)
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Kategori</h4>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold text-primary">{{ $dokumen->kategori->nama_kategori }}</h6>
                    @if($dokumen->kategori->deskripsi)
                        <p class="text-muted small mb-0">{{ $dokumen->kategori->deskripsi }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Description Card -->
    @if($dokumen->deskripsi)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Deskripsi</h4>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $dokumen->deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

</section>
@endsection
