<html>
<head>
    <title>Login - SIVERA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #90c2e7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        @keyframes subtleShadowPulse {
            0% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            50% {
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            }
            100% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 15px;
            display: flex;
            width: 800px;
            padding: 40px;
            animation: subtleShadowPulse 4s infinite ease-in-out;
        }

        .login-left {
            flex: 1.2;
            text-align: center;
            padding-right: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .img-logo {
            max-width: 180px;
            margin-bottom: 10px;
        }

        .teks-sistem {
            color: #558cac;
            font-size: 16px;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .img-illustration {
            max-width: 100%;
            height: auto;
        }

        .login-right {
            flex: 1;
            padding-left: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-size: 30px;
            margin-bottom: 30px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            margin-bottom: 8px;
            color: #555;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 12px 12px 12px 45px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #38b6ff;
            box-shadow: 0 0 0 3px rgba(56, 182, 255, 0.2);
        }

        .form-control:focus+i,
        .input-wrapper:focus-within i {
            color: #38b6ff;
        }

        .lupa-sandi {
            display: block;
            font-size: 12px;
            color: #888;
            text-decoration: none;
            margin-bottom: 15px;
            transition: color 0.3s;
        }

        .lupa-sandi:hover {
            color: #38b6ff;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #90c2e7;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        .btn-login:hover {
            background-color: #38b6ff;
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
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
            <h2>Selamat Datang!</h2>
            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>ID Pengguna</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username..."value="{{ old('username') }}" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi..." required>
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <a href="{{ route('lupa-sandi') }}" class="lupa-sandi">Lupa kata sandi?</a>

                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </div>
</body>

</html>