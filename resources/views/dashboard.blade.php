@extends('layouts/app2')
@section('title', 'Dashboard | SiArsip')
@section('judul', 'Dashboard')
@section('content')
<section class="section">
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
            <i class="far fa-newspaper"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Total Arsip</h4>
            </div>
            <div class="card-body">
            {{$totalArsip}}
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
            <i class="far fa-file"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Total Surat Masuk</h4>
            </div>
            <div class="card-body">
            {{$totalSuratMasuk}}
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="fas fa-circle"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Total Surat Keluar</h4>
            </div>
            <div class="card-body">
            {{$totalSuratKeluar}}
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
        <div class="card-icon bg-info">
            <i class="fas fa-tags"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
            <h4>Total Kategori</h4>
            </div>
            <div class="card-body">
            {{$totalKategori}}
            </div>
        </div>
        </div>
    </div>
</div>
</section>
</section>

@endsection

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout> --}}
