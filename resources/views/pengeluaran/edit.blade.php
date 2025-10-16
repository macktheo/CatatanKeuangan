@extends('layouts.app')
@section('title', 'Edit Pengeluaran')

@section('content')

    
    <div class="card shadow-lg card-shadow">
        <div class="card-body">
            @include('pengeluaran.form') 
        </div>
    </div>
@endsection