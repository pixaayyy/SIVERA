@extends('layouts.app')

@section('title', 'Dashboard Inventaris')

@section('content')
    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        <div style="flex: 1; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h4>Total Barang</h4>
            <h2 style="color: #38b6ff;">9</h2>
        </div>
        <div style="flex: 1; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h4>Barang Rusak</h4>
            <h2 style="color: #dc3545;">2</h2>
        </div>
        <div style="flex: 1; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h4>Total Karyawan</h4>
            <h2 style="color: #ffc107;">15</h2>
        </div>
    </div>
    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h3>Barang Rusak Masuk</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <tr style="background: #f4f7f6; text-align: left;">
                <th style="padding: 10px;">Tanggal</th>
                <th style="padding: 10px;">Barang & Tipe</th>
                <th style="padding: 10px;">Status</th>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">15 Okt 2026</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">PC - ASUS</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee; color: red;">Rusak</td>
            </tr>
        </table>
    </div>
@endsection