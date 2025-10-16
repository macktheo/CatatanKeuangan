@extends('layouts.app') 
@section('title', 'Tambah Pemasukan')
@section('content')
    <h1 class="mb-4 text-success"><i class="fas fa-plus-circle me-2"></i> Tambah Pemasukan Baru</h1>
    
    <div class="card shadow-lg card-shadow">
        <div class="card-body">
            @include('pemasukan.form') 
        </div>
    </div>
@endsection