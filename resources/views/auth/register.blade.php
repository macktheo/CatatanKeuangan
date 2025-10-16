<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Catatan Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .register-bg {
            /* Gradien Biru-Cyan yang sama dengan Login */
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%); 
            height: 100vh;
        }
        .card-register {
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Shadow yang lembut */
        }
        .input-group-text {
            /* Hilangkan border dan background untuk tampilan minimalis */
            border-right: none;
            background-color: transparent;
        }
        .form-control.border-minimal {
            /* Hanya border bawah yang terlihat */
            border-top: 0;
            border-right: 0;
            border-left: 0;
            border-radius: 0;
            padding-left: 5px;
        }
        .form-control.border-minimal:focus {
            box-shadow: none;
            border-color: #4facfe; /* Warna biru saat fokus */
        }
    </style>
</head>
<body class="register-bg d-flex justify-content-center align-items-center">

    <div class="card card-register p-5" style="width: 450px;">
        <div class="card-body p-0">
            <h2 class="text-center text-primary mb-2 fw-bold">Buat Akun Baru</h2>
            <p class="text-center text-muted mb-4">Gratis! Mulai kelola keuangan Anda.</p>

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                
                <div class="mb-3 input-group">
                    <span class="input-group-text border-0 ps-0"><i class="fas fa-user text-muted"></i></span>
                    <input type="text" class="form-control border-minimal @error('name') is-invalid @enderror" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-3 input-group">
                    <span class="input-group-text border-0 ps-0"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="email" class="form-control border-minimal @error('email') is-invalid @enderror" name="email" placeholder="Email Aktif" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-3 input-group">
                    <span class="input-group-text border-0 ps-0"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" class="form-control border-minimal @error('password') is-invalid @enderror" name="password" placeholder="Password (Min 8 Karakter)" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-4 input-group">
                    <span class="input-group-text border-0 ps-0"><i class="fas fa-key text-muted"></i></span>
                    <input type="password" class="form-control border-minimal" name="password_confirmation" placeholder="Konfirmasi Password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 mb-3 fw-bold py-2">
                    <i class="fas fa-user-plus me-2"></i> Daftar
                </button>
            </form>
        </div>
        <div class="text-center mt-3">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk di sini</a>
        </div>
    </div>

</body>
</html>