@extends('layouts.sidebar.admin')

@section('title', 'Backup Sistem - SIVERA')

@section('content')
<style>
    .main-content { 
        flex: 1; 
        display: flex; 
        flex-direction: column; 
        background-color: #f8fafc;
        min-height: 100vh;
    }
    .topbar { 
        background: #fff; 
        padding: 15px 30px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
    }
    .topbar h2 { 
        margin: 0; 
        font-size: 20px; 
        color: #333; 
    }
    .content-body {
        padding: 30px;
    }
    .backup-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 10px;
    }
    .backup-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .backup-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }
    .icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        font-size: 32px;
    }
    .icon-db { background: #e0f2fe; color: #0284c7; }
    .icon-code { background: #dcfce7; color: #16a34a; }
    
    .backup-card h3 {
        margin: 0 0 10px 0;
        color: #1e293b;
        font-size: 18px;
    }
    .backup-card p {
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 25px;
    }
    .btn-download {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        color: #fff;
        transition: 0.2s;
        border: none;
        cursor: pointer;
        width: 100%;
        box-sizing: border-box;
    }
    .btn-db { background-color: #0ea5e9; }
    .btn-db:hover { background-color: #0284c7; }
    
    .btn-code { background-color: #10b981; }
    .btn-code:hover { background-color: #059669; }

    .alert-box {
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
        animation: fadeOutAlert 0.5s ease-out 3s forwards; 
    }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    
    @keyframes fadeOutAlert {
        0% { opacity: 1; max-height: 100px; margin-bottom: 20px; padding: 12px 20px; }
        100% { opacity: 0; max-height: 0; margin-bottom: 0; padding: 0; border: none; overflow: hidden; }
    }
</style>

<div class="main-content">
    <div class="topbar">
        <h2>Backup Data</h2>
        <div class="topbar-right">
            @include('notifikasi')
        </div>
    </div>

    <div class="content-body">
        
        @if(session('error'))
            <div class="alert-box alert-error">
                <i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="backup-grid">
            <div class="backup-card">
                <div class="icon-wrapper icon-db">
                    <i class="fa-solid fa-database"></i>
                </div>
                <h3>Backup Database</h3>
                <p>Unduh seluruh data dari tabel database dalam format SQL.</p>
                <a href="{{ route('admin.backup.database') }}" class="btn-download btn-db" onclick="showLoading(this)">
                    <i class="fa-solid fa-cloud-arrow-down"></i> Unduh Database
                </a>
            </div>

            <div class="backup-card">
                <div class="icon-wrapper icon-code">
                    <i class="fa-solid fa-code"></i>
                </div>
                <h3>Backup Source Code</h3>
                <p>Unduh struktur folder aplikasi, views, controller, dan konfigurasi ke dalam format .ZIP.</p>
                <a href="{{ route('admin.backup.source') }}" class="btn-download btn-code" onclick="showLoading(this)">
                    <i class="fa-solid fa-file-zipper"></i> Unduh Source Code
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function showLoading(element) {
        let originalText = element.innerHTML;
        element.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        element.style.pointerEvents = 'none';
        element.style.opacity = '0.7';

        setTimeout(() => {
            element.innerHTML = originalText;
            element.style.pointerEvents = 'auto';
            element.style.opacity = '1';
        }, 4000);
    }
</script>
@endsection