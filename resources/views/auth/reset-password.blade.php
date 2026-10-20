<!DOCTYPE html>
<html>
<head>
    <title>Reset Kata Sandi - SIVERA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; background-color: #90c2e7; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-container { background-color: #ffffff; border-radius: 15px; display: flex; width: 800px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .login-left { flex: 1.2; text-align: center; padding-right: 30px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .img-logo { max-width: 180px; margin-bottom: 10px; }
        .teks-sistem { color: #38b6ff; font-size: 14px; font-weight: 500; margin-bottom: 20px; }
        .img-illustration { max-width: 100%; height: auto; }
        .login-right { flex: 1; padding-left: 30px; display: flex; flex-direction: column; justify-content: center; }
        .login-right h2 { font-size: 22px; margin-bottom: 25px; color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; margin-bottom: 6px; color: #555; }
        .form-control { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; }
        .form-control:focus { border-color: #38b6ff; }
        .btn-login { width: 100%; padding: 12px; background-color: #90c2e7; border: none; border-radius: 8px; color: white; font-size: 15px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn-login:hover { background-color: #38b6ff; }
        .error-msg { color: #dc3545; font-size: 12px; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <img src="{{ asset('images/logosivera.png') }}" alt="Logo SIVERA" class="img-logo">
            <p class="teks-sistem">Sistem Informasi Inventaris Barang Rusak</p>
            <img src="{{ asset('images/coversivera.png') }}" alt="Ilustrasi" class="img-illustration">
        </div>
        <div class="login-right">
            <h2>Buat Kata Sandi Baru</h2>
            
            <form action="{{ route('password.store') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $request->email }}" required readonly>
                </div>

                <div class="form-group">
                    <label>Kata Sandi Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
                </div>

                <button type="submit" class="btn-login">Perbarui Kata Sandi</button>
            </form>
        </div>
    </div>
</body>
</html>