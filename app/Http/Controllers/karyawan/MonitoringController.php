<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
                $query->whereYear('tanggal_masuk', $parts[0])->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $query->whereMonth('tanggal_masuk', $bulan);
                $query->whereYear('tanggal_masuk', $request->filled('tahun') ? $request->tahun : date('Y'));
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

        $barang = $query->join('kategori', 'barang.kategori_barang', '=', 'kategori.id_kategori')
            ->orderBy('kategori.jenis_kategori', 'asc')
            ->orderBy('barang.tanggal_masuk', 'desc')
            ->select('barang.*')
            ->get();

        $tanggalTertua = Barang::min('tanggal_masuk');
        $tahunTertua = $tanggalTertua ? date('Y', strtotime($tanggalTertua)) : date('Y');

        return view('karyawan.monitoring', compact('barang', 'tahunTertua'));
    }

    public function exportPdf(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_masuk', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            if (strpos($bulan, '-') !== false) {
                $parts = explode('-', $bulan);
                $query->whereYear('tanggal_masuk', $parts[0])->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $query->whereMonth('tanggal_masuk', $bulan);
                $query->whereYear('tanggal_masuk', $request->filled('tahun') ? $request->tahun : date('Y'));
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

        $barang = (clone $query)->join('kategori', 'barang.kategori_barang', '=', 'kategori.id_kategori')
            ->orderBy('kategori.jenis_kategori', 'asc')
            ->orderBy('barang.tanggal_masuk', 'desc')
            ->select('barang.*')
            ->get();

        $rekapQuery = Barang::query()->join('kategori', 'barang.kategori_barang', '=', 'kategori.id_kategori');

        if ($request->filled('tanggal')) {
            $rekapQuery->whereDate('tanggal_masuk', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            if (strpos($bulan, '-') !== false) {
                $parts = explode('-', $bulan);
                $rekapQuery->whereYear('tanggal_masuk', $parts[0])->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $rekapQuery->whereMonth('tanggal_masuk', $bulan);
                $rekapQuery->whereYear('tanggal_masuk', $request->filled('tahun') ? $request->tahun : date('Y'));
            }
        } elseif ($request->filled('tahun')) {
            $rekapQuery->whereYear('tanggal_masuk', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $rekapQuery->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($subq) use ($search) {
                      $subq->where('jenis_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $rekapKategori = $rekapQuery->select('kategori_barang', DB::raw('SUM(jumlah_unit) as total_unit'))
            ->groupBy('kategori_barang', 'kategori.jenis_kategori')
            ->orderBy('kategori.jenis_kategori', 'asc')
            ->with('kategori')
            ->get();

        $pdf = Pdf::loadView('karyawan.pdf_monitoring', compact('barang', 'rekapKategori'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Monitoring_Barang_SIVERA.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_masuk', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            if (strpos($bulan, '-') !== false) {
                $parts = explode('-', $bulan);
                $query->whereYear('tanggal_masuk', $parts[0])->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $query->whereMonth('tanggal_masuk', $bulan);
                $query->whereYear('tanggal_masuk', $request->filled('tahun') ? $request->tahun : date('Y'));
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

        $barang = (clone $query)->join('kategori', 'barang.kategori_barang', '=', 'kategori.id_kategori')
            ->orderBy('kategori.jenis_kategori', 'asc')
            ->orderBy('barang.tanggal_masuk', 'desc')
            ->select('barang.*')
            ->get();

        $rekapQuery = Barang::query()->join('kategori', 'barang.kategori_barang', '=', 'kategori.id_kategori');

        if ($request->filled('tanggal')) {
            $rekapQuery->whereDate('tanggal_masuk', $request->tanggal);
        }
        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            if (strpos($bulan, '-') !== false) {
                $parts = explode('-', $bulan);
                $rekapQuery->whereYear('tanggal_masuk', $parts[0])->whereMonth('tanggal_masuk', $parts[1]);
            } else {
                $rekapQuery->whereMonth('tanggal_masuk', $bulan);
                $rekapQuery->whereYear('tanggal_masuk', $request->filled('tahun') ? $request->tahun : date('Y'));
            }
        } elseif ($request->filled('tahun')) {
            $rekapQuery->whereYear('tanggal_masuk', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $rekapQuery->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('nomor_asset', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($subq) use ($search) {
                      $subq->where('jenis_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $rekapKategori = $rekapQuery->select('kategori_barang', DB::raw('SUM(jumlah_unit) as total_unit'))
            ->groupBy('kategori_barang', 'kategori.jenis_kategori')
            ->orderBy('kategori.jenis_kategori', 'asc')
            ->with('kategori')
            ->get();

        $view = view('karyawan.excel_monitoring', compact('barang', 'rekapKategori'));

        return response($view, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="Laporan_Monitoring_Barang_SIVERA.xls"',
        ]);
    }
}