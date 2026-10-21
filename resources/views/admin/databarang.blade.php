@extends('layouts.sidebar.admin')

@section('content')
<style>
    .databarang-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc; 
        min-height: 100vh;
    }

    .page-header {
        background-color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        border-bottom: 1px solid #e2e8f0;
    }

    .header-title {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #333;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .date-badge { 
        padding: 8px 15px; 
        background: #fff; 
        border: 1px solid #ddd; 
        border-radius: 20px; 
        font-size: 12px; 
        color: #555; 
    }

    .notif-btn {
        font-size: 20px;
        color: #64748b;
        position: relative;
        cursor: pointer;
        background: transparent;
        border: none;
        width: auto;
        height: auto;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notif-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
    }

    .content-body {
        padding: 30px; 
    }

    .inventory-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .filter-section {
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
        background-color: #ffffff;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: minmax(140px, 1.1fr) minmax(150px, 1.1fr) minmax(145px, 1.1fr) minmax(150px, 1.1fr) auto;
        gap: 10px;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        width: 100%;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; 
        pointer-events: none; 
    }

    .search-input-with-icon {
        padding-left: 38px !important; 
    }

    .form-control-custom {
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
        padding: 10px 12px;
        height: 38px;
        background-color: #f8fafc;
        border: 1px solid #dbe4f0;
        border-radius: 8px;
        font-size: 13px;
        color: #334155;
        outline: none;
        transition: border-color 0.2s, background-color 0.2s;
    }

    .form-control-custom:focus {
        border-color: #3b82f6;
        background-color: #ffffff;
    }

    .btn-action-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-filter,
    .btn-reset {
        height: 38px;
        padding: 0 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-filter {
        background-color: #3b82f6;
        color: #ffffff;
        border: 1px solid #3b82f6;
    }

    .btn-filter:hover {
        background-color: #2563eb;
    }

    .btn-reset {
        background-color: #ffffff;
        color: #3b82f6;
        border: 1px solid #93c5fd;
    }

    .btn-reset:hover {
        background-color: #eff6ff;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .custom-table th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 15px 20px;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 15px 20px;
        font-size: 13px;
        color: #475569;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }

    .custom-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .custom-table td:nth-child(2) {
        font-weight: 600;
        color: #1e293b;
    }

    .status-badge {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        color: #dc2626;
    }

    .action-icons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .icon-btn-edit,
    .icon-btn-delete {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: background 0.2s;
    }

    .icon-btn-edit {
        background: #eff6ff;
        color: #3b82f6;
        border: 1px solid #bfdbfe;
    }

    .icon-btn-edit:hover {
        background: #dbeafe;
    }

    .icon-btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .icon-btn-delete:hover {
        background: #fee2e2;
    }

    .empty-data {
        text-align: center;
        padding: 32px !important;
        color: #94a3b8 !important;
    }

    @media (max-width: 1100px) {
        .filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .btn-action-group {
            grid-column: 1 / -1;
        }

        .btn-filter,
        .btn-reset {
            flex: 1;
        }
    }

    @media (max-width: 600px) {
        .page-header {
            padding: 15px 20px;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .content-body {
            padding: 15px;
        }

        .header-title {
            font-size: 18px;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="databarang-container">
    <div class="page-header">
        <h2 class="header-title">Data Barang Inventaris</h2>

        <div class="header-right">
            <div class="date-badge">
                <i class="fa-regular fa-calendar"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
            </div>
            @include('notifikasi')
        </div>
    </div>

    <div class="content-body">
        <div class="inventory-card">
            
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.databarang') }}" class="filter-grid">
                    
                    <div class="search-wrapper">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari..."
                            class="form-control-custom search-input-with-icon"
                        >
                    </div>

                    <select name="kategori" class="form-control-custom">
                        <option value="">Semua kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->jenis_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="form-control-custom">
                        <option value="">Semua status</option>
                        <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Ready" {{ request('status') == 'Ready' ? 'selected' : '' }}>Ready</option>
                    </select>

                    <input
                        type="date"
                        name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="form-control-custom"
                    >

                    <div class="btn-action-group">
                        <button type="submit" class="btn-filter">Filter</button>
                        <a href="{{ route('admin.databarang') }}" class="btn-reset" title="Reset Filter">Reset</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Ex User</th>
                            <th>No Asset</th>
                            <th>Status</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($barang as $item)
                            <tr>
                                <td>{{ $item->tanggal_masuk }}</td>
                                <td>{{ $item->kategori ? $item->kategori->jenis_kategori : '-' }}</td>
                                <td>{{ $item->nama_barang }} {{ $item->tipe }}</td>
                                <td>{{ $item->ex_user }}</td>
                                <td style="font-family: monospace; font-size: 13px;">{{ $item->nomor_asset }}</td>
                                <td>
                                    <span class="status-badge">{{ $item->status_barang }}</span>
                                </td>
                                <td>
                                    <div class="action-icons">
                                        <a href="{{ route('admin.editbarang', $item->id_barang) }}" class="icon-btn-edit" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.deletebarang', $item->id_barang) }}" method="POST" id="form-delete-{{ $item->id_barang }}" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="icon-btn-delete" title="Hapus" style="cursor: pointer;" onclick="confirmDelete('{{ $item->id_barang }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.032 2.032 0 0116.138 21H7.862a2.032 2.032 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-data">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .swal2-cancel.custom-cancel-btn {
        background-color: #ffffff !important;
        color: #000000 !important;
        border: 1px solid #d1d5db !important;
    }
    .swal2-cancel.custom-cancel-btn:hover {
        background-color: #f3f4f6 !important;
    }
</style>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda akan menghapus barang ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#ffffff', 
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                cancelButton: 'custom-cancel-btn' 
            },
            reverseButtons: true 
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>
@endsection