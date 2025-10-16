@extends('layouts.app')
@section('title', 'Edit Pemasukan')

@section('content')
    {{-- Judul Halaman: Menggunakan warna Hijau (Success) --}}
    <h1 class="mb-4 text-success">
        <i class="fas fa-edit me-2"></i> 
        Edit Pemasukan: {{ $pemasukan->deskripsi }}
    </h1>
    
    <div class="card shadow-lg card-shadow">
        <div class="card-body">
            {{-- Memuat form inti. Variabel $pemasukan sudah tersedia dari Controller --}}
            @include('pemasukan.form') 
        </div>
    </div>
@endsection