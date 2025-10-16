@extends('layouts.app')

@section('title', 'Dashboard - Mutasi Keuangan')

<style>
    .mb-4 {
        margin-top: 15px !important; 
    }
</style>

@section('content')

    <h1 class="mb-4 text-dark fw-light">
        <span class="border-bottom border-primary border-4 pb-2">
            <i class="fas fa-chart-line me-2 text-primary"></i>
            Ringkasan Kinerja Keuangan
        </span>
    </h1>
    
    {{-- BARIS 1: INFORMASI SALDO & KINERJA BULAN INI --}}
    <div class="row mb-5">
        
        {{-- CARD 1: Saldo Total --}}
        <div class="col-md-4">
            <div class="card shadow-lg border-0 border-start border-primary border-5 h-100">
                <div class="card-body">
                    <div class="text-uppercase fw-bold text-primary mb-1">Saldo Total Saat Ini</div>
                    <div class="h4 mb-0 fw-bold">Rp {{ number_format($saldoSaatIni, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- CARD 2: Pemasukan Bulan Ini --}}
        <div class="col-md-4">
            <div class="card shadow-lg border-0 border-start border-success border-5 h-100">
                <div class="card-body">
                    <div class="text-uppercase fw-bold text-success mb-1">Pemasukan Bulan Ini</div>
                    <div class="h4 mb-0 fw-bold">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- CARD 3: Pengeluaran Bulan Ini --}}
        <div class="col-md-4">
            <div class="card shadow-lg border-0 border-start border-danger border-5 h-100">
                <div class="card-body">
                    <div class="text-uppercase fw-bold text-danger mb-1">Pengeluaran Bulan Ini</div>
                    <div class="h4 mb-0 fw-bold">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- VISUALISASI DAN AKSES CEPAT --}}
    <div class="row">
        
        {{-- KOLOM KIRI (8 Kolom): GRAFIK MUTASI HISTORIS --}}
        <div class="col-md-8"> 
            <div class="card shadow-lg mb-4 card-shadow">
                <div class="card-header py-3 bg-light">
                    <h5 class="m-0 fw-bold text-primary">Mutasi Keuangan Historis (Per Bulan)</h5>
                </div>
                <div class="card-body" style="height: 400px;">
                    @if (empty($chartData))
                        <div class="alert alert-warning text-center mt-5">Belum ada transaksi untuk membuat grafik.</div>
                    @else
                        <canvas id="monthlyMutasiChart"></canvas>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- KOLOM KANAN (4 Kolom): TRANSAKSI TERAKHIR --}}
        <div class="col-md-4">
            <div class="card shadow-lg mb-4 card-shadow">
                <div class="card-header py-3 bg-light">
                    <h5 class="m-0 fw-bold text-secondary">5 Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    @if($lastTransactions->isEmpty())
                        <div class="alert alert-info text-center">Belum ada transaksi tercatat.</div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($lastTransactions as $trans)
                                @php
                                    $transColor = $trans->type === 'Pemasukan' ? 'text-success' : 'text-danger';
                                    $transIcon = $trans->type === 'Pemasukan' ? 'fas fa-arrow-down' : 'fas fa-arrow-up';
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="{{ $transIcon }} {{ $transColor }} me-2"></i>
                                        <span class="fw-bold">{{ $trans->type }}</span>: {{ $trans->deskripsi }}
                                    </div>
                                    <span class="fw-bold {{ $transColor }}">{{ number_format($trans->amount, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if(Auth::user()->role === 'admin')
    <div class="alert alert-info shadow-sm border-2 border-info border-start mt-4">
        <i class="fas fa-user-shield me-2"></i> **Fasilitas Admin:** Anda dapat mengelola user lain melalui menu *Manajemen User*.
    </div>
    @endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Data Mutasi Bulanan (Historis)
    const chartData = @json($chartData); 
    
    if (chartData.length > 0) {
        const labels = chartData.map(d => d.label);
        const pemasukan = chartData.map(d => d.pemasukan);
        const pengeluaran = chartData.map(d => d.pengeluaran);

        const ctx = document.getElementById('monthlyMutasiChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: pemasukan,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)', // Hijau
                        borderRadius: 5,
                    },
                    {
                        label: 'Pengeluaran',
                        data: pengeluaran,
                        backgroundColor: 'rgba(220, 53, 69, 0.7)', // Merah
                        borderRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                label += ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endpush