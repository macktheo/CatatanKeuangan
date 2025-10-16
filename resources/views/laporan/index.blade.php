@extends('layouts.app')

@section('title', 'Laporan Rincian Transaksi Harian')

@section('content')
    <h1 class="mb-4 text-primary"><i class="fas fa-clipboard-list me-2"></i> Laporan Rincian Transaksi Harian</h1>

    <div class="card shadow-lg card-shadow mb-4">
        <div class="card-header bg-primary text-white py-3">Filter Periode Laporan</div>
        <div class="card-body">
            
            {{-- FORM FILTER --}}
            <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $tanggalMulai ?? '' }}" required>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $tanggalSelesai ?? '' }}" required>
                </div>
                
                {{-- Tombol Cari --}}
                <div class="col-md-2">
                    <button type="submit" name="filter" value="1" class="btn btn-primary w-100 fw-bold"><i class="fas fa-search"></i> Terapkan</button>
                </div>
                
                {{-- Tombol Export PDF --}}
                @if(!$transaksi->isEmpty())
                <div class="col-md-4">
                    <a href="{{ route('laporan.export.pdf', ['tanggal_mulai' => $tanggalMulai, 'tanggal_selesai' => $tanggalSelesai]) }}" class="btn btn-danger w-100 fw-bold">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>
    
    {{-- Hasil Transaksi Harian --}}
    @if(!$transaksi->isEmpty())
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="p-3 border rounded text-center bg-success text-white fw-bold shadow-sm">
                    Total Pemasukan: <br> Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 border rounded text-center bg-danger text-white fw-bold shadow-sm">
                    Total Pengeluaran: <br> Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </div>
            </div>
            {{-- CARD SISA SALDO --}}
            <div class="col-md-4">
                <div class="p-3 border rounded text-center bg-info text-white fw-bold shadow-sm">
                    Sisa Saldo: <br> Rp {{ number_format($saldoPeriode, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="card shadow-lg card-shadow mb-4">
            <div class="card-header bg-secondary text-white py-3">
                Rincian Transaksi Harian: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="table-dark text-white">
                                <th style="width: 15%;">Tanggal</th>
                                <th style="width: 10%;">Jenis</th>
                                <th>Deskripsi</th>
                                <th style="width: 20%;" class="text-end">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop data per transaksi --}}
                            @foreach($transaksi as $item)
                                @php
                                    $color = $item->type === 'Pemasukan' ? 'text-success' : 'text-danger';
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <td class="fw-bold {{ $color }}">{{ $item->type }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td class="text-end fw-bold {{ $color }}">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-primary fw-bold">
                                <td colspan="3" class="text-end">SALDO PERIODE INI</td>
                                <td class="text-end">Rp {{ number_format($saldoPeriode, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
    @else
        <div class="alert alert-info text-center">
             <i class="fas fa-info-circle me-2"></i> Silakan masukkan rentang tanggal untuk melihat rincian transaksi harian. Saat ini menampilkan data dari {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} sampai {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d F Y') }}.
        </div>
    @endif
@endsection