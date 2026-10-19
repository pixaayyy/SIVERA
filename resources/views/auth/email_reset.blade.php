<html>
<head>
    <title>Atur Ulang Kata Sandi</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #38b6ff; text-align: center;">SIVERA</h2>
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun SIVERA Anda.</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('reset-password.form', ['token' => $token, 'email' => $email]) }}" style="background-color: #38b6ff; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Atur Ulang Kata Sandi</a>
        </div>
        <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini.</p>
        <p>Terima kasih,<br>Tim SIVERA</p>
    </div>
</body>
</html>