<table>
    <tr>
        <td colspan="7" style="font-size: 14px; font-weight: bold; text-align: center; border: none;">
            Data Barang Inventaris Gudang Departemen IT 
        </td>
    </tr>
    <tr>
        <td colspan="7" style="font-size: 11px; text-align: center; border: none; color: #000000;">
            PT. Solusi Bangun Indonesia Tbk. Cilacap Plant 1
        </td>
    </tr>
    <tr><td colspan="7" style="border: none;"></td></tr> 

    <tr>
        <td colspan="3" style="text-align: left; font-size: 11px; border: none; font-weight: bold;">
            Tanggal Cetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
        </td>
        <td colspan="4" style="text-align: right; font-size: 11px; border: none; font-weight: bold;">
            Total Data: {{ count($barang) }} Unit
        </td>
    </tr>
    <tr><td colspan="7" style="border: none;"></td></tr> 

    <tr style="background-color: #ebf8ff;">
        <th style="border: 1px solid #cbd5e0; color: #000000; font-weight: bold; text-align: center; padding: 8px;">NO</th>
        <th style="border: 1px solid #cbd5e0; color: #000000; font-weight: bold; text-align: center; padding: 8px;">NO ASSET</th>
        <th style="border: 1px solid #cbd5e0; color: #000000; font-weight: bold; text-align: center; padding: 8px;">NAMA BARANG</th>
        <th style="border: 1px solid #cbd5e0; color: #000000; font-weight: bold; text-align: center; padding: 8px;">JENIS KATEGORI</th>
        <th style="border: 1px solid #cbd5e0; color: #000000; font-weight: bold; text-align: center; padding: 8px;">TIPE</th>
        <th style="border: 1px solid #cbd5e0; color: #000000; font-weight: bold; text-align: center; padding: 8px;">JUMLAH UNIT</th>
        <th style="border: 1px solid #cbd5e0; color: #000000; font-weight: bold; text-align: center; padding: 8px;">TANGGAL MASUK</th>
    </tr>

    <tbody>
        @forelse ($barang as $index => $item)
            <tr>
                <td style="border: 1px solid #cbd5e0; text-align: center; padding: 6px;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #cbd5e0; text-align: center; padding: 6px;">{{ $item->nomor_asset ?? '-' }}</td>
                <td style="border: 1px solid #cbd5e0; text-align: left; padding: 6px;">{{ $item->nama_barang }}</td>
                <td style="border: 1px solid #cbd5e0; text-align: center; padding: 6px;">{{ $item->kategori ? $item->kategori->jenis_kategori : '-' }}</td>
                <td style="border: 1px solid #cbd5e0; text-align: center; padding: 6px;">{{ $item->tipe }}</td>
                <td style="border: 1px solid #cbd5e0; text-align: center; padding: 6px;">{{ $item->jumlah_unit }}</td>
                <td style="border: 1px solid #cbd5e0; text-align: center; padding: 6px;">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="border: 1px solid #cbd5e0; text-align: center; padding: 15px; color: #a0aec0;">
                    Tidak ada data barang yang sesuai pencarian.
                </td>
            </tr>
        @endforelse
    </tbody>

    <tr><td colspan="7" style="border: none;"></td></tr>
    <tr>
        <td colspan="7" style="font-size: 11px; font-weight: bold; border: none; text-align: left;">
            REKAPITULASI JUMLAH UNIT PER KATEGORI:
        </td>
    </tr>
    <tr style="background-color: #ebf8ff;">
        <td colspan="4" style="border: 1px solid #cbd5e0; font-weight: bold; text-align: center;">Jenis Kategori</td>
        <td colspan="3" style="border: 1px solid #cbd5e0; font-weight: bold; text-align: center;">Total Unit</td>
    </tr>
    @foreach($rekapKategori as $rekap)
    <tr>
        <td colspan="4" style="border: 1px solid #cbd5e0; text-align: left; padding: 5px;">{{ $rekap->kategori ? $rekap->kategori->jenis_kategori : '-' }}</td>
        <td colspan="3" style="border: 1px solid #cbd5e0; text-align: center; padding: 5px;">{{ $rekap->total_unit }} Unit</td>
    </tr>
    @endforeach

    <tr><td colspan="7" style="border: none;"></td></tr>
    <tr><td colspan="7" style="border: none;"></td></tr>
    <tr>
        <td colspan="5" style="border: none;"></td>
        <td colspan="2" style="text-align: center; border: none; font-size: 11px;">
            Cilacap, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
        </td>
    </tr>
    <tr>
        <td colspan="5" style="border: none;"></td>
        <td colspan="2" style="text-align: center; border: none; font-size: 11px; font-weight: bold;">
            Kepala Departemen IT
        </td>
    </tr>
    <tr><td colspan="7" style="border: none; height: 40px;"></td></tr>
    <tr>
        <td colspan="5" style="border: none;"></td>
        <td colspan="2" style="text-align: center; border: none; font-size: 11px;">
            <u>( ..................................................... )</u>
        </td>
    </tr>
</table>