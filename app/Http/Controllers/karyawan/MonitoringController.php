<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_masuk', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            
            if (strpos($bulan, '-') !== false) {
                $parts = explode('-', $bulan);
                $query->whereYear('tanggal_masuk', $parts[0])
                      ->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $query->whereMonth('tanggal_masuk', $bulan);
                
                if ($request->filled('tahun')) {
                    $query->whereYear('tanggal_masuk', $request->tahun);
                } else {
                    $query->whereYear('tanggal_masuk', date('Y'));
                }
            }
        } elseif ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($subq) use ($search) {
                      $subq->where('jenis_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $barang = $query->orderBy('tanggal_masuk', 'desc')->get();
        $tanggalTertua = Barang::min('tanggal_masuk');
        $tahunTertua = $tanggalTertua ? date('Y', strtotime($tanggalTertua)) : date('Y');

        return view('karyawan.monitoring', compact('barang', 'tahunTertua'));
    }

    public function exportPdf(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            if (strpos($bulan, '-') !== false) {
                $parts = explode('-', $bulan);
                $query->whereYear('tanggal_masuk', $parts[0])
                      ->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $query->whereMonth('tanggal_masuk', $bulan);
                if ($request->filled('tahun')) {
                    $query->whereYear('tanggal_masuk', $request->tahun);
                } else {
                    $query->whereYear('tanggal_masuk', date('Y'));
                }
            }
        } elseif ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($subq) use ($search) {
                      $subq->where('jenis_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $barang = $query->orderBy('tanggal_masuk', 'desc')->get();

        $pdf = Pdf::loadView('karyawan.pdf_monitoring', compact('barang'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Monitoring_Barang_SIVERA.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            if (strpos($bulan, '-') !== false) {
                $parts = explode('-', $bulan);
                $query->whereYear('tanggal_masuk', $parts[0])
                      ->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $query->whereMonth('tanggal_masuk', $bulan);
                if ($request->filled('tahun')) {
                    $query->whereYear('tanggal_masuk', $request->tahun);
                } else {
                    $query->whereYear('tanggal_masuk', date('Y'));
                }
            }
        } elseif ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($subq) use ($search) {
                      $subq->where('jenis_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $barang = $query->orderBy('tanggal_masuk', 'desc')->get();

        $view = view('karyawan.excel_monitoring', compact('barang'));

        return response($view, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="Laporan_Monitoring_Barang_SIVERA.xls"',
        ]);
    }
}