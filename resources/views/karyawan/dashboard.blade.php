@extends('layouts.sidebar.karyawan')
@section('title', 'Dashboard Inventaris')
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
    .notification {
        font-size: 20px;
        color: #888;
        position: relative;
        cursor: pointer;
    }
    .notification::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        background: red;
        border-radius: 50%;
    }

    .dashboard-body {
        padding: 30px;
        background-color: #f4f7f6;
        min-height: calc(100vh - 65px);
    }
</style>

<div class="topbar">
    <h2>Dashboard Inventaris</h2>
    <div class="topbar-right">
        <div class="date-badge">
            <i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
        </div>
        @include('notifikasi')
    </div>
</div>

<div class="dashboard-body">    
    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div style="flex: 1; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 10px 0; color: #888; font-weight: 500;">Total Barang</h4>
                <h2 style="margin: 0; color: #38b6ff; font-size: 32px;">{{ $totalBarang ?? 0 }}</h2>
                <span style="font-size: 10px; color: #aaa;">Semua aset tercatat</span>
            </div>
            <div style="background: #e6f5ff; padding: 15px; border-radius: 10px;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 24px; color: #38b6ff;"></i>
            </div>
        </div>

        <div style="flex: 1; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 10px 0; color: #888; font-weight: 500;">Barang Rusak</h4>
                <h2 style="margin: 0; color: #dc3545; font-size: 32px;">{{ $barangRusak ?? 0 }}</h2>
                <span style="font-size: 10px; color: #aaa;">Barang tidak dapat digunakan</span>
            </div>
            <div style="background: #ffebeb; padding: 15px; border-radius: 10px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 24px; color: #dc3545;"></i>
            </div>
        </div>

        <div style="flex: 1; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 10px 0; color: #888; font-weight: 500;">Barang Ready</h4>
                <h2 style="margin: 0; color: #28a745; font-size: 32px;">{{ $barangReady ?? 0 }}</h2>
                <span style="font-size: 10px; color: #aaa;">Barang siap digunakan</span>
            </div>
            <div style="background: #ebf9ee; padding: 15px; border-radius: 10px;">
                <i class="fa-solid fa-check-circle" style="font-size: 24px; color: #28a745;"></i>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
        
        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <h3 style="margin: 0 0 20px 0; color: #2b5c7a; font-size: 16px;"><i class="fa-solid fa-table-cells"></i> Kategori Barang</h3>
            
            @forelse($kategoriStats ?? [] as $kategori)
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: 8px; font-weight: 500;">
                    <span>{{ $kategori->nama_kategori }}</span>
                    <span>{{ $kategori->persentase }}%</span>
                </div>
                <div style="background: #f0f0f0; height: 12px; border-radius: 10px; width: 100%; overflow: hidden;">
                    <div style="background: #2b5c7a; height: 100%; width: {{ $kategori->persentase }}%; border-radius: 10px;"></div>
                </div>
            </div>
            @empty
            <p style="font-size: 13px; color: #888; text-align: center;">Belum ada data kategori barang.</p>
            @endforelse
        </div>

        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <h3 style="margin: 0 0 20px 0; color: #2b5c7a; font-size: 16px;"><i class="fa-solid fa-warehouse"></i> Barang Rusak Masuk</h3>
            
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left;">
                        <th style="padding: 12px 15px; border-bottom: 2px solid #edf2f7; color: #555; font-weight: 600;">Tanggal</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #edf2f7; color: #555; font-weight: 600;">Barang & Tipe</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #edf2f7; color: #555; font-weight: 600;">Ex User</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #edf2f7; color: #555; font-weight: 600;">Status</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #edf2f7; color: #555; font-weight: 600;">No Asset</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangRusakMasuk ?? [] as $barang)
                    <tr>
                        <td style="padding: 12px 15px; border-bottom: 1px solid #edf2f7; color: #666;">
                            {{ \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d-m-Y') }}
                        </td>
                        <td style="padding: 12px 15px; border-bottom: 1px solid #edf2f7;">
                            <strong style="color: #333;">{{ $barang->nama_barang }}</strong><br>
                            <span style="color: #888; font-size: 11px;">{{ $barang->tipe }}</span>
                        </td>
                        <td style="padding: 12px 15px; border-bottom: 1px solid #edf2f7; color: #666;">
                            {{ $barang->ex_user ?? '-' }}
                        </td>
                        <td style="padding: 12px 15px; border-bottom: 1px solid #edf2f7; color: #dc3545; font-weight: 500;">
                            {{ $barang->status_barang }}
                        </td>
                        <td style="padding: 12px 15px; border-bottom: 1px solid #edf2f7; color: #666;">
                            IT-{{ str_pad($barang->nomor_asset, 3, '0', STR_PAD_LEFT) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center; color: #888;">Belum ada data barang rusak masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
