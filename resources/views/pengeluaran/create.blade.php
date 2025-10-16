@extends('layouts.app') 
@section('title', 'Tambah Pengeluaran')
@section('content')
    <h1 class="mb-4 text-danger"><i class="fas fa-plus-circle me-2"></i> Tambah Pengeluaran Baru</h1>
    
    <div class="card shadow-lg card-shadow">
        <div class="card-body">
            {{-- PASTIKAN PATH FILE FORM INI BENAR --}}
            @include('pengeluaran.form') 
        </div>
    </div>
@endsection