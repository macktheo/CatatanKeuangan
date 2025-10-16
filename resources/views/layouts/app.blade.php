<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catatan Keuangan')</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Gaya Umum */
        body { 
            background-color: #f8f9fa; 
        }
        .navbar-custom {
            /* Menggunakan gradien biru-cyan dari halaman Login */
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%); 
        }
        .nav-link.active {
            font-weight: bold;
            /* Garis bawah putih yang tipis sebagai indikator aktif */
            border-bottom: 3px solid #f8f9fa; 
        }
        .main-content { 
            padding-top: 20px;
            padding-bottom: 50px;
        }
        .card-shadow { box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05); }

        /* Responsif: Menyesuaikan Padding Brand di Mobile */
        @media (max-width: 992px) {
            .navbar-brand {
                font-size: 1.1rem;
                margin-right: 1rem !important;
            }
            .navbar-nav {
                margin-top: 10px; /* Tambahkan sedikit jarak di mobile */
            }
        }
    </style>
</head>
<body>

    <!-- NAV BAR HORIZONTAL (Tampilan Desktop: Semua Menu di Baris) -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top navbar-custom">
        <div class="container-fluid px-4">
            {{-- Brand Tetap di Kiri --}}
            <a class="navbar-brand fw-bold text-white me-5" href="{{ route('dashboard') }}">
                <i class="fas fa-wallet me-2 text-warning"></i> Catatan Keuangan
            </a>
            
            {{-- Tombol Hamburger untuk Mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Link Navigasi Utama --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-pie me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pemasukan*') ? 'active' : '' }}" href="{{ route('pemasukan.index') }}">
                            <i class="fas fa-arrow-down me-1"></i> Pemasukan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pengeluaran*') ? 'active' : '' }}" href="{{ route('pengeluaran.index') }}">
                            <i class="fas fa-arrow-up me-1"></i> Pengeluaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                            <i class="fas fa-file-alt me-1"></i> Laporan
                        </a>
                    </li>
                    {{-- Navigasi Admin Opsional --}}
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users-cog me-1"></i> Manajemen User
                        </a>
                    </li>
                    @endif
                </ul>

                {{-- Logout dan User Info (Di Kanan) --}}
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3 text-white fw-bold">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm fw-bold">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <!-- Main Content Area -->
    <div class="container main-content">
        
         <!-- Notifikasi Alert -->
         @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>