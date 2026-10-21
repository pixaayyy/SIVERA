@extends('layouts.sidebar.admin')

@section('title', 'Tambah Karyawan - SIVERA')

@section('content')
<style>
    /* Latar belakang untuk memusatkan form */
    .main-container {
        padding: 30px;
        background-color: #f4f7f6; /* Warna abu-abu terang */
        min-height: calc(100vh - 65px);
        display: flex;
        justify-content: center;
        align-items: center; /* Memposisikan card di tengah secara vertikal */
    }

    /* Styling kotak form (Card/Modal) */
    .custom-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 40px;
        width: 100%;
        max-width: 800px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    /* Tombol silang (X) di pojok kanan atas */
    .close-btn {
        position: absolute;
        top: 25px;
        right: 30px;
        font-size: 24px;
        color: #888;
        text-decoration: none;
        font-weight: bold;
        transition: 0.2s;
    }
    .close-btn:hover {
        color: #333;
    }

    .custom-card h3 {
        font-size: 22px;
        font-weight: 600;
        color: #222;
        margin-bottom: 30px;
    }

    /* Membuat Layout 2 Kolom dengan CSS Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr; /* 2 kolom berukuran sama */
        gap: 20px 40px; /* Jarak antar baris dan antar kolom */
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #333;
    }

    /* Styling Input Field */
    .form-control {
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        color: #333;
        width: 100%;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #56baf8;
        box-shadow: 0 0 5px rgba(86, 186, 248, 0.3);
    }

    /* Area Tombol */
    .btn-container {
        display: flex;
        justify-content: flex-end; /* Memposisikan tombol di kanan */
        gap: 15px;
        margin-top: 40px;
        margin-right: 20px;
    }

    .btn-batal {
        padding: 10px 35px;
        border: 2px solid #56baf8;
        background: transparent;
        color: #56baf8;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        font-size: 15px;
        transition: 0.3s;
    }

    .btn-tambah {
        padding: 10px 35px;
        border: none;
        background: #56baf8;
        color: white;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        font-size: 15px;
        transition: 0.3s;
    }

    .btn-batal:hover {
        background: #f0f8ff;
    }

    .btn-tambah:hover {
        background: #3aa8f2;
    }
</style>

<div class="main-container">
    <div class="custom-card">
        <!-- Tombol silang di kanan atas mengarah kembali ke data karyawan -->
        <a href="{{ route('admin.datakaryawan') }}" class="close-btn">&times;</a>
        
        <h3>Tambah Data Karyawan</h3>
        
        <form action="{{ route('admin.karyawan.simpan') }}" method="POST">
            @csrf
            <div class="form-grid">
                <!-- Baris 1 -->
                <div class="form-group">
                    <label for="nama_karyawan">Nama Karyawan :</label>
                    <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" placeholder="Masukan Nama Karyawan" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email Karyawan" required>
                </div>
                
                <!-- Baris 2 -->
                <div class="form-group">
                    <label for="username">Username :</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukan Username Karyawan" required>
                </div>
                
                <div class="form-group mb-3">
                    <label for="password">Password :</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" class="form-control" style="padding-right: 40px;" required>
                        <button type="button" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; cursor: pointer; color: #6c757d; padding: 0;">
                            <i class="fas fa-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                    <small style="color: red; font-size: 13px; display: block; margin-top: 5px;">* Notes: Password minimal 6 karakter.</small>
                </div>

                <div class="form-group">
                    <label for="role">Role :</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Karyawan">Karyawan</option>
                    </select>
                </div>
                
                <div></div>
            </div>

            <div class="btn-container">
                <a href="{{ route('admin.datakaryawan') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-tambah">Tambah</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    });
</script>
@endsection
