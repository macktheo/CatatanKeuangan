<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Catatan Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .login-bg {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%); 
            height: 100vh;
        }
        .card-login {
            border-radius: 1rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="login-bg d-flex justify-content-center align-items-center">

    <div class="card card-login p-4" style="width: 420px;">
        <div class="card-body">
            <h2 class="text-center text-primary mb-2 fw-bold"><i class="fas fa-wallet me-2"></i> Financial Log</h2>
            <p class="text-center text-muted mb-4">Silakan masuk ke akun Anda.</p>

            @error('email')<div class="alert alert-danger text-center">{{ $message }}</div>@enderror

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class="mb-3 input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
                    <input type="email" class="form-control" name="email" placeholder="Email Anda" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-4 input-group input-group-lg">
                    <span class="input-group-text bg-light"><i class="fas fa-lock text-primary"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 fw-bold">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk
                </button>
            </form>
        </div>
        <div class="card-footer text-center bg-transparent border-0">
            Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar di sini</a>
        </div>
    </div>

</body>
</html>