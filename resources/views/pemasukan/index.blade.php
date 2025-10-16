@extends('layouts.app')

@section('title', 'Data Pemasukan')

@section('content')
    <h1 class="mb-4 text-success"><i class="fas fa-money-bill-wave me-2"></i> Daftar Pemasukan</h1>

    <div class="card shadow-lg card-shadow">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Tabel Pemasukan Terkini</h5>
            <a href="{{ route('pemasukan.create') }}" class="btn btn-light btn-sm fw-bold text-success">
                <i class="fas fa-plus me-1"></i> Tambah Pemasukan
            </a>
        </div>
        <div class="card-body">
            {{-- BARIS YANG DIPERBAIKI (Di sekitar baris 17) --}}
            @if($pemasukan->isEmpty()) 
                <div class="alert alert-info text-center">Belum ada data pemasukan yang tercatat. Mari catat yang pertama!</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr class="table-success">
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Bukti Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemasukan as $item) {{-- Pastikan menggunakan $pemasukan --}}
                                <tr>
                                    <td>{{ $loop->iteration + $pemasukan->firstItem() - 1 }}</td> {{-- Pastikan menggunakan $pemasukan --}}
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td class="text-success fw-bold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->bukti_gambar)
                                            <a href="{{ asset('storage/' . $item->bukti_gambar) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pemasukan.edit', $item->id) }}" class="btn btn-sm btn-primary me-1" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('pemasukan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    {{ $pemasukan->links() }} {{-- Pastikan menggunakan $pemasukan --}}
                </div>
            @endif
        </div>
    </div>
@endsection