<style>
    .sidebar {
        width: 250px;
        background-color: white;
        border-right: 1px solid #ddd;
        display: flex;
        flex-direction: column;
    }
    .sidebar-brand {
        padding: 20px;
        text-align: center;
        color: #38b6ff;
        font-weight: bold;
        font-size: 24px;
        border-bottom: 1px solid #eee;
    }
    .sidebar-menu {
        flex: 1;
        padding: 20px 0;
    }
    .menu-item {
        padding: 15px 20px;
        display: block;
        color: #555;
        text-decoration: none;
    }
    .menu-item:hover, .menu-item.active {
        background-color: #f0f8ff;
        color: #38b6ff;
        border-right: 3px solid #38b6ff;
    }
    .sidebar-footer {
        padding: 20px;
        border-top: 1px solid #eee;
    }
    .btn-logout {
        width: 100%;
        padding: 10px;
        background: white;
        border: 1px solid #dc3545;
        color: #dc3545;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
<div class="sidebar">
    <div class="sidebar-brand">SIVERA<br><span style="font-size: 10px; color: #888;">Admin Panel</span></div>
    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="menu-item active">Dashboard</a>
        <a href="#" class="menu-item">Manajemen Pengguna</a>
        <a href="#" class="menu-item">Kategori Barang</a>
        <a href="#" class="menu-item">Laporan Kerusakan</a>
    </div>
    <div class="sidebar-footer">
        <div style="margin-bottom: 10px;"><b>{{ Auth::user()->name }}</b></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</div>