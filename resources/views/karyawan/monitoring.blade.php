<html>
    <head>
        <title>Monitoring Barang - SIVERA</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                background-color: #f4f7fb;
                display: flex;
                min-height: 100vh;
            }

            .main-wrapper {
                flex: 1;
                display: flex;
                flex-direction: column;
                overflow-x: hidden;
            }

            .top-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 40px;
                background-color: #ffffff;
                border-bottom: 1px solid #e2e8f0;
            }

            .top-header h1 {
                font-size: 24px;
                font-weight: 700;
                color: #2d3748;
            }

            .header-right {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .date-badge {
                border: 1px solid #cbd5e0;
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 13px;
                color: #4a5568;
                display: flex;
                align-items: center;
                gap: 8px;
                background-color: #fff;
            }

            .notification-bell {
                position: relative;
                font-size: 20px;
                color: #4a5568;
                cursor: pointer;
            }

            .notification-badge-dot {
                position: absolute;
                top: -2px;
                right: 0px;
                width: 8px;
                height: 8px;
                background-color: #e53e3e;
                border-radius: 50%;
            }

            .content-container {
                padding: 30px 40px;
            }

            .card {
                background-color: #ffffff;
                border-radius: 16px;
                padding: 35px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            }

            .card-header-title {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 25px;
            }

            .company-info h2 {
                font-size: 18px;
                font-weight: 700;
                color: #2d3748;
                margin-bottom: 4px;
            }

            .company-info p {
                font-size: 14px;
                color: #718096;
                font-weight: 500;
            }

            .filter-section {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .select-filter {
                padding: 8px 12px;
                border: 1px solid #cbd5e0;
                border-radius: 8px;
                font-size: 13px;
                color: #718096;
                outline: none;
                background-color: #fff;
            }

            .btn-reset {
                background-color: #63b3ed;
                color: white;
                border: none;
                padding: 8px 20px;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
            }

            .btn-reset:hover {
                background-color: #4299e1;
            }

            .divider-line {
                height: 1px;
                background-color: #e2e8f0;
                margin-bottom: 25px;
            }

            .action-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px;
                margin-bottom: 30px;
            }

            .search-box {
                position: relative;
                flex: 1;
            }

            .search-box i {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #a0aec0;
                font-size: 16px;
            }

            .search-input {
                width: 100%;
                padding: 10px 15px 10px 42px;
                border: 1px solid #cbd5e0;
                border-radius: 20px;
                font-size: 13px;
                outline: none;
                color: #4a5568;
            }

            .search-input::placeholder {
                color: #a0aec0;
            }

            .btn-download-pdf {
                background-color: #63b3ed;
                color: white;
                border: none;
                padding: 10px 22px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                cursor: pointer;
                white-space: nowrap;
            }

            .btn-download-pdf:hover {
                background-color: #4299e1;
            }

            .table-responsive {
                width: 100%;
                overflow-x: auto;
            }

            .custom-table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            .custom-table th {
                background-color: #ebf8ff;
                color: #2b6cb0;
                font-size: 14px;
                font-weight: 600;
                padding: 14px 10px;
            }

            .custom-table th:first-child {
                border-top-left-radius: 8px;
                border-bottom-left-radius: 8px;
            }

            .custom-table th:last-child {
                border-top-right-radius: 8px;
                border-bottom-right-radius: 8px;
            }

            .custom-table td {
                padding: 14px 10px;
                font-size: 13px;
                color: #4a5568;
                border-bottom: 1px solid #edf2f7;
            }

            .empty-row {
                padding: 30px !important;
                color: #a0aec0;
                font-style: italic;
            }
        </style>
    </head>
    <body>

        @include('layouts.sidebar.karyawan')

        <div class="main-wrapper">
            
            <div class="top-header">
                <h1>Monitoring Barang</h1>
                <div class="header-right">
                    <div class="date-badge">
                        <i class="fa-regular fa-calendar"></i>
                        <span>{{ \Carbon\Carbon::now()->isoFormat('D MMM YYYY') }}</span>
                    </div>
                    <div class="notification-bell">
                        <i class="fa-regular fa-bell"></i>
                        <div class="notification-badge-dot"></div>
                    </div>
                </div>
            </div>

            <div class="content-container">
                <div class="card">
                    
                    <form action="{{ route('karyawan.monitoring') }}" method="GET">
                        <div class="card-header-title">
                            <div class="company-info">
                                <h2>Monitoring Barang Rusak Gudang Departemen IT</h2>
                                <p>PT. Solusi Bangun Indonesia Tbk. Cilacap Plant 1</p>
                            </div>
                            
                            <div class="filter-section">
                                <select name="bulan" class="select-filter" onchange="this.form.submit()">
                                    <option value="">Pilih Bulan</option>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ sprintf('%02d', $m) }}" {{ request('bulan') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>

                                <select name="tahun" class="select-filter" onchange="this.form.submit()">
                                    <option value="">Pilih Tahun</option>
                                    @for ($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>

                                <a href="{{ route('karyawan.monitoring') }}" class="btn-reset">Reset</a>
                            </div>
                        </div>

                        <div class="divider-line"></div>

                        <div class="action-row">
                            <div class="search-box">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" name="search" class="search-input" placeholder="Cari berdasarkan kode, nama, tipe atau no asset..." value="{{ request('search') }}">
                            </div>

                            <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                                <a href="{{ url('/karyawan/monitoring/export-pdf?' . http_build_query(request()->all())) }}" class="btn-download-pdf">
                                    <i class="fa-solid fa-download"></i> Unduh Laporan
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jenis Kategori</th>
                                    <th>Total Unit</th>
                                    <th>Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barang as $item)
                                    <tr>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->kategori ? $item->kategori->jenis_kategori : '-' }}</td>
                                        <td>{{ $item->jumlah_unit }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanSggal_masuk)->format('d-m-Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="empty-row">Data barang tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </body>
</html>