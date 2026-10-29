<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Laporan Monitoring Barang - SIVERA</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 18px;
                color: #333;
                margin: 0;
                padding: 0;
            }
            .header-kop {
                border-bottom: 2px solid #000000;
                padding-bottom: 12px;
                margin-bottom: 20px;
            }
            .header-table {
                width: 100%;
                border-collapse: collapse;
                border: none;
            }
            .header-table td {
                border: none !important;
                padding: 0;
                vertical-align: middle;
            }
            .header-title-h2 {
                margin: 0;
                font-size: 18px;
                color: #000000;
                text-transform: uppercase;
                font-weight: bold;
            }
            .header-title-h3 {
                margin: 4px 0 0 0;
                font-size: 14px;
                color: #000000;
                font-weight: normal;
            }
            .meta-info {
                margin-bottom: 15px;
                font-size: 11px;
                width: 100%;
                border-collapse: collapse;
            }
            .meta-info td {
                border: none !important;
                padding: 2px 0;
            }
            table.data-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 5px;
            }
            table.data-table th {
                background-color: #ebf8ff;
                color: #000000;
                border: 1px solid #cbd5e0;
                padding: 8px 10px;
                font-size: 11px;
                text-align: center;
                text-transform: uppercase;
            }
            table.data-table td {
                border: 1px solid #e2e8f0;
                padding: 7px 10px;
                font-size: 11px;
                text-align: center;
            }
            table.data-table tr:nth-child(even) {
                background-color: #f7fafc;
            }
            .rekap-table {
                width: 40%;
                border-collapse: collapse;
                margin-top: 15px;
                margin-bottom: 25px;
                font-size: 11px;
            }
            .rekap-table th, .rekap-table td {
                border: 1px solid #cbd5e0;
                padding: 6px 10px;
            }
            .rekap-table th {
                background-color: #ebf8ff;
                text-align: left;
            }
            .ttd-section {
                margin-top: 30px;
                width: 100%;
            }
            .ttd-box {
                float: right;
                width: 220px;
                text-align: center;
                font-size: 11px;
            }
            .ttd-space {
                height: 60px;
            }
        </style>
    </head>
    <body>

        <div class="header-kop">
            <table class="header-table">
                <tr>
                    <td style="width: 100%; text-align: center;">
                        <h2 class="header-title-h2">Data Barang Inventaris Gudang Departemen IT</h2>
                        <h3 class="header-title-h3">PT. Solusi Bangun Indonesia Tbk. Cilacap Plant 1</h3>
                    </td>
                </tr>
            </table>
        </div>

        <table class="meta-info">
            <tr>
                <td style="text-align: left;">
                    <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                </td>
                <td style="text-align: right;">
                    <strong>Total Data:</strong> {{ count($barang) }} Unit
                </td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">No Asset</th>
                    <th width="25%">Nama Barang</th>
                    <th width="15%">Jenis Kategori</th>
                    <th width="15%">Tipe</th>
                    <th width="10%">Jumlah Unit</th>
                    <th width="18%">Tanggal Masuk</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nomor_asset ?? '-' }}</td>
                        <td style="text-align: left;">{{ $item->nama_barang }}</td>
                        <td>{{ $item->kategori ? $item->kategori->jenis_kategori : '-' }}</td>
                        <td>{{ $item->tipe }}</td>
                        <td>{{ $item->jumlah_unit }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 20px; color: #a0aec0;">Tidak ada data barang yang sesuai dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h4 style="font-size: 12px; margin: 20px 0 5px 0;">Rekapitulasi Jumlah Unit per Kategori:</h4>
        <table class="rekap-table">
            <thead>
                <tr>
                    <th>Jenis Kategori</th>
                    <th style="text-align: center;">Total Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekapKategori as $rekap)
                <tr>
                    <td>{{ $rekap->kategori ? $rekap->kategori->jenis_kategori : '-' }}</td>
                    <td style="text-align: center;">{{ $rekap->total_unit }} Unit</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="ttd-section">
            <div class="ttd-box">
                <p>Cilacap, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
                <p><strong>Kepala Departemen IT</strong></p>
                <div class="ttd-space"></div>
                <p><u>( ..................................... )</u></p>
            </div>
        </div>

    </body>
</html>