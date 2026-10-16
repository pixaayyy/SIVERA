<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIVERA - Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            height: 100vh;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    @if(Auth::user()->role === 'admin')
        @include('layouts.sidebar.admin')
    @else
        @include('layouts.sidebar.karyawan')
    @endif

    <div class="main-content">
        <div class="topbar">
            <h2>@yield('title')</h2>
            <div>{{ date('l, d M Y') }}</div>
        </div>
        @yield('content')
    </div>
</body>
</html>