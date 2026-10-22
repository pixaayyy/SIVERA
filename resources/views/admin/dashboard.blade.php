@extends('layouts.sidebar.admin')

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
        @includeIf('notifikasi') 
    </div>
</div>

<div class="dashboard-body">    
    <div style="display: flex; gap: 15px; margin-bottom: 30px;">
        <div style="flex: 1; background: white; padding: 18px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 8px 0; color: #888; font-weight: 500; font-size: 13px;">Total Barang</h4>
                <h2 style="margin: 0; color: #38b6ff; font-size: 26px;">{{ $totalBarang ?? 0 }}</h2>
                <span style="font-size: 10px; color: #aaa;">Semua aset tercatat</span>
            </div>
            <div style="background: #e6f5ff; padding: 12px; border-radius: 8px;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 20px; color: #38b6ff;"></i>
            </div>
        </div>

        <div style="flex: 1; background: white; padding: 18px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 8px 0; color: #888; font-weight: 500; font-size: 13px;">Barang Ready</h4>
                <h2 style="margin: 0; color: #38a169; font-size: 26px;">{{ $barangReady ?? 0 }}</h2>
                <span style="font-size: 10px; color: #aaa;">Siap digunakan</span>
            </div>
            <div style="background: #f0fff4; padding: 12px; border-radius: 8px;">
                <i class="fa-solid fa-check-circle" style="font-size: 20px; color: #38a169;"></i>
            </div>
        </div>

        <div style="flex: 1; background: white; padding: 18px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 8px 0; color: #888; font-weight: 500; font-size: 13px;">Barang Rusak</h4>
                <h2 style="margin: 0; color: #e53e3e; font-size: 26px;">{{ $barangRusak ?? 0 }}</h2>
                <span style="font-size: 10px; color: #aaa;">Tidak dapat digunakan</span>
            </div>
            <div style="background: #fff5f5; padding: 12px; border-radius: 8px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 20px; color: #e53e3e;"></i>
            </div>
        </div>

        <div style="flex: 1; background: white; padding: 18px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 8px 0; color: #555; font-weight: 500; font-size: 13px;">Total Karyawan</h4>
                <h2 style="margin: 0; color: #d4a338; font-size: 26px;">{{ $totalKaryawan ?? 0 }}</h2>
                <span style="font-size: 10px; color: #aaa;">Departemen IT</span>
            </div>
            <div style="background: #f8f6d6; padding: 12px; border-radius: 8px;">
                <i class="fa-solid fa-user" style="font-size: 20px; color: #d4a338;"></i>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
        
        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <h3 style="margin: 0 0 20px 0; color: #2b5c7a; font-size: 16px;"><i class="fa-solid fa-table-cells"></i> Kategori Barang</h3>
            
            @forelse($kategoriStats ?? [] as $kategori)
            <div style="margin-bottom: 22px; padding-bottom: 12px; border-bottom: 1px solid #f0f0f0;">
                <div style="display: flex; justify-content: space-between; font-size: 13px; color: #333; margin-bottom: 6px; font-weight: 600;">
                    <span>{{ $kategori->nama_kategori }} (Total: {{ $kategori->total_unit }} Unit)</span>
                </div>
                
                <div style="background: #edf2f7; height: 10px; border-radius: 10px; width: 100%; overflow: hidden; display: flex; margin-bottom: 8px;">
                    <div style="background: #48bb78; width: {{ $kategori->persentase_ready }}%; height: 100%;" title="Ready: {{ $kategori->persentase_ready }}%"></div>
                    <div style="background: #fc8181; width: {{ $kategori->persentase_rusak }}%; height: 100%;" title="Rusak: {{ $kategori->persentase_rusak }}%"></div>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 11px;">
                    <span style="color: #38a169; font-weight: 600;">Ready: {{ $kategori->total_ready }} Unit ({{ $kategori->persentase_ready }}%)</span>
                    <span style="color: #e53e3e; font-weight: 600;">Rusak: {{ $kategori->total_rusak }} Unit ({{ $kategori->persentase_rusak }}%)</span>
                </div>
            </div>
            @empty
            <p style="font-size: 13px; color: #888; text-align: center;">Belum ada data kategori barang.</p>
            @endforelse
        </div>

        <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <h3 style="margin: 0 0 20px 0; color: #2b5c7a; font-size: 16px;"><i class="fa-solid fa-warehouse"></i> Barang Masuk Hari Ini </h3>
            
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left;">
                        <th style="padding: 12px 15px; border-bottom: 2px solid #edf2f7; color: #555; font-weight: 600;">Kategori Barang</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #edf2f7; color: #555; font-weight: 600; text-align: center;">Total Unit Masuk Hari Ini</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapBarangMasuk ?? [] as $item)
                    <tr>
                        <td style="padding: 12px 15px; border-bottom: 1px solid #edf2f7; color: #333; font-weight: 600;">
                            {{ $item->kategori ? $item->kategori->jenis_kategori : '-' }}
                        </td>
                        <td style="padding: 12px 15px; border-bottom: 1px solid #edf2f7; color: #2b5c7a; font-weight: bold; text-align: center;">
                            {{ $item->total_unit }} Unit
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" style="padding: 20px; text-align: center; color: #888;">Belum ada data barang masuk hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection