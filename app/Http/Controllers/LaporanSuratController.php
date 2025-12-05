<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanSuratExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanSuratController extends Controller
{
    public function index(Request $request)
    {
        // Default periode
        $periode = $request->get('periode', 'bulanan');
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $minggu = $request->get('minggu');
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_akhir = $request->get('tanggal_akhir');

        // Query untuk surat masuk
        $querySuratMasuk = Dokumen::with(['kategori', 'suratMasuk'])->where('jenis_surat', 'surat_masuk');
        $querySuratKeluar = Dokumen::with(['kategori', 'suratKeluar'])->where('jenis_surat', 'surat_keluar');
        // dd($querySuratKeluar->get());

        // Filter berdasarkan periode
        switch ($periode) {
            case 'mingguan':
                if ($minggu && $tahun) {
                    $startOfWeek = Carbon::now()->setISODate($tahun, $minggu)->startOfWeek();
                    $endOfWeek = Carbon::now()->setISODate($tahun, $minggu)->endOfWeek();

                    $querySuratMasuk->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    $querySuratKeluar->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                }
                break;

            case 'bulanan':
                $querySuratMasuk->whereMonth('created_at', $bulan)
                                ->whereYear('created_at', $tahun);
                $querySuratKeluar->whereMonth('created_at', $bulan)
                                ->whereYear('created_at', $tahun);
                break;

            case 'tahunan':
                $querySuratMasuk->whereYear('created_at', $tahun);
                $querySuratKeluar->whereYear('created_at', $tahun);
                break;

            case 'custom':
                if ($tanggal_mulai && $tanggal_akhir) {
                    $querySuratMasuk->whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir]);
                    $querySuratKeluar->whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir]);
                }
                break;
        }

        // Get data
        $suratMasuk = $querySuratMasuk->orderBy('created_at', 'desc')->get();
        $suratKeluar = $querySuratKeluar->orderBy('created_at', 'desc')->get();

        // Hitung statistik
        $totalSuratMasuk = $suratMasuk->count();
        $totalSuratKeluar = $suratKeluar->count();
        $totalKeseluruhan = $totalSuratMasuk + $totalSuratKeluar;

        // Hitung rasio
        $rasio = $totalSuratKeluar > 0
            ? round($totalSuratMasuk / $totalSuratKeluar, 2)
            : ($totalSuratMasuk > 0 ? '∞' : 0);

        // Group by kategori
        $suratMasukPerKategori = $suratMasuk->groupBy(function($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        })->map->count();

        $suratKeluarPerKategori = $suratKeluar->groupBy(function($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        })->map->count();

        // Top pengirim
        $topPengirim = $suratMasuk->groupBy('pengirim')
                                   ->map->count()
                                   ->sortDesc()
                                   ->take(5);

        // Top tujuan
        $topTujuan = $suratKeluar->groupBy('tujuan')
                                  ->map->count()
                                  ->sortDesc()
                                  ->take(5);

                                //   dd($suratKeluar, $suratMasuk);
        return view('laporan.surat.index', compact(
            'suratMasuk',
            'suratKeluar',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalKeseluruhan',
            'rasio',
            'suratMasukPerKategori',
            'suratKeluarPerKategori',
            'topPengirim',
            'topTujuan',
            'periode',
            'bulan',
            'tahun',
            'minggu',
            'tanggal_mulai',
            'tanggal_akhir'
        ));
    }

    public function exportExcel(Request $request)
    {
        $periode = $request->get('periode', 'bulanan');
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $minggu = $request->get('minggu');
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_akhir = $request->get('tanggal_akhir');

        // Generate filename
        $filename = 'Laporan_Surat_' . ucfirst($periode) . '_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new LaporanSuratExport($periode, $bulan, $tahun, $minggu, $tanggal_mulai, $tanggal_akhir),
            $filename
        );
    }

    public function exportPdf(Request $request)
    {
        $periode = $request->get('periode', 'bulanan');
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $minggu = $request->get('minggu');
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_akhir = $request->get('tanggal_akhir');

        // Query untuk surat masuk
        $querySuratMasuk = Dokumen::with(['kategori', 'suratMasuk'])->where('jenis_surat', 'surat_masuk');
        $querySuratKeluar = Dokumen::with(['kategori', 'suratKeluar'])->where('jenis_surat', 'surat_keluar');


        // Filter berdasarkan periode
        switch ($periode) {
            case 'mingguan':
                if ($minggu && $tahun) {
                    $startOfWeek = Carbon::now()->setISODate($tahun, $minggu)->startOfWeek();
                    $endOfWeek = Carbon::now()->setISODate($tahun, $minggu)->endOfWeek();

                    $querySuratMasuk->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    $querySuratKeluar->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                }
                break;

            case 'bulanan':
                $querySuratMasuk->whereMonth('created_at', $bulan)
                                ->whereYear('created_at', $tahun);
                $querySuratKeluar->whereMonth('created_at', $bulan)
                                ->whereYear('created_at', $tahun);
                break;

            case 'tahunan':
                $querySuratMasuk->whereYear('created_at', $tahun);
                $querySuratKeluar->whereYear('created_at', $tahun);
                break;

            case 'custom':
                if ($tanggal_mulai && $tanggal_akhir) {
                    $querySuratMasuk->whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir]);
                    $querySuratKeluar->whereBetween('created_at', [$tanggal_mulai, $tanggal_akhir]);
                }
                break;
        }

        // Get data
        $suratMasuk = $querySuratMasuk->orderBy('created_at', 'desc')->get();
        $suratKeluar = $querySuratKeluar->orderBy('created_at', 'desc')->get();

        // Hitung statistik
        $totalSuratMasuk = $suratMasuk->count();
        $totalSuratKeluar = $suratKeluar->count();
        $totalKeseluruhan = $totalSuratMasuk + $totalSuratKeluar;

        // Generate periode text
        $periodeText = $this->getPeriodeText($periode, $bulan, $tahun, $minggu, $tanggal_mulai, $tanggal_akhir);

        $pdf = Pdf::loadView('laporan.surat.pdf', compact(
            'suratMasuk',
            'suratKeluar',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalKeseluruhan',
            'periodeText',
            'periode'
        ));

        $filename = 'Laporan_Surat_' . ucfirst($periode) . '_' . date('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }

    private function getPeriodeText($periode, $bulan, $tahun, $minggu, $tanggal_mulai, $tanggal_akhir)
    {
        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        switch ($periode) {
            case 'mingguan':
                return "Minggu ke-{$minggu} Tahun {$tahun}";
            case 'bulanan':
                return $bulanNama[$bulan] . " {$tahun}";
            case 'tahunan':
                return "Tahun {$tahun}";
            case 'custom':
                return date('d/m/Y', strtotime($tanggal_mulai)) . " - " . date('d/m/Y', strtotime($tanggal_akhir));
            default:
                return '';
        }
    }
}
