<html>
<head>
    <title>SIVERA - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: white;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .sidebar-brand img {
            max-width: 130px;
            margin-bottom: 5px;
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

        .sidebar-profile {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            margin-top: auto; 
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .avatar-icon {
            margin-right: 12px;
            display: flex;
            align-items: center;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 2px;
        }

        .user-email {
            font-size: 12px;
            color: #4b5563;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 8px 16px;
            background-color: transparent;
            color: #dc2626; 
            font-size: 16px;
            font-weight: 600;
            border: 2px solid #d1d5db; 
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background-color: #fef2f2;
            border-color: #dc2626;
        }

        .main-wrapper {
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logosivera.png') }}" alt="Logo SIVERA">
            <br>
            <span style="font-size: 10px; color: #0077be; font-weight: 600;">Sistem Informasi Inventaris Barang Rusak</span>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.tambahbarang') }}" class="menu-item {{ request()->routeIs('admin.tambahbarang') ? 'active' : '' }}" class="menu-item">Tambah Barang</a>
            <a href="{{ route('admin.databarang') }}" class="menu-item {{ request()->routeIs('admin.databarang') ? 'active' : '' }}" class="menu-item" class="menu-item">Data Barang</a>
            <a href="{{ route('admin.datakaryawan') }}" class="menu-item {{ request()->routeIs('admin.datakaryawan') ? 'active' : '' }}" class="menu-item" class="menu-item" class="menu-item">Data Karyawan</a>
            <a href="{{ route('admin.monitoring') }}" class="menu-item {{ request()->routeIs('admin.monitoring') ? 'active' : '' }}" class="menu-item" class="menu-item" class="menu-item" class="menu-item">Monitoring Barang</a>
            <a href="{{ route('admin.backup') }}" class="menu-item {{ request()->routeIs('admin.backup') ? 'active' : '' }}" class="menu-item" class="menu-item" class="menu-item" class="menu-item">Backup</a>
        </div>

        <div class="sidebar-profile">
            <div class="user-info">
                <div class="avatar-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" fill="#757575">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
                
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#dc2626" style="margin-right: 8px;">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-wrapper">
        @yield('content')
    </div>

</body>
</html>

