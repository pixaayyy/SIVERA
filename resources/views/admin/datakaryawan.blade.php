@extends('layouts.sidebar.admin')

@section('title', 'Data Karyawan - SIVERA')

@section('content')
<style>
    .topbar {
        background: #ffffff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border-bottom: 1px solid #eee;
    }
    .topbar h2 {
        margin: 0;
        font-size: 20px;
        color: #333;
        font-weight: 600;
    }
    .topbar-right {
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

    .main-container {
        padding: 30px;
        background-color: #f4f7f6;
        min-height: calc(100vh - 65px);
    }

    .card {
        background: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header h3 {
        margin: 0;
        color: #111;
        font-size: 20px;
        font-weight: 600;
    }

    .btn-tambah {
        background-color: #56baf8;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-tambah:hover {
        background-color: #3aa8f2;
    }

    .table-karyawan {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    
    .table-karyawan th, .table-karyawan td {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .table-karyawan th {
        background-color: #e8f4fa;
        color: #333;
        font-weight: 600;
        font-size: 14px;
    }

    .table-karyawan td {
        color: #555;
        font-size: 14px;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    .btn-icon {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        text-decoration: none;
    }
    .btn-edit { color: #56baf8; }
    .btn-delete { color: #e3342f; }
</style>

<div class="topbar">
    <h2>Data Karyawan</h2>
    <div class="topbar-right">
        <div class="date-badge">
            <i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
        </div>
        @includeIf('notifikasi')
    </div>
</div>

<div class="main-container">
    <div class="card">
        <div class="card-header">
            <h3>Data Karyawan Departemen IT</h3>
            <a href="{{ route('admin.karyawan.tambah') }}" class="btn-tambah">
                <i class="fa-solid fa-plus"></i> Tambah Karyawan
            </a>
        </div>

        <table class="table-karyawan">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawan ?? [] as $karyawan)
                <tr>
                    <td>{{ $karyawan->nama_karyawan }}</td>
                    <td>{{ $karyawan->user->email ?? '-' }}</td>
                    <td>{{ $karyawan->user->username ?? '-' }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn-icon btn-edit" title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            
                           <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data karyawan ini?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 30px; color: #888; text-align: center;">Belum ada data karyawan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 1500 
        });
    });
</script>
@endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonColor: '#d33'
            });
        });
    </script>
    @endif
@endsection