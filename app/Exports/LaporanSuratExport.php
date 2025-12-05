<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Dokumen;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanSuratExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $periode;
    protected $bulan;
    protected $tahun;
    protected $minggu;
    protected $tanggal_mulai;
    protected $tanggal_akhir;

    public function __construct($periode, $bulan, $tahun, $minggu = null, $tanggal_mulai = null, $tanggal_akhir = null)
    {
        $this->periode = $periode;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->minggu = $minggu;
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function view(): View
    {
        /// Query untuk surat masuk
        $querySuratMasuk = Dokumen::with(['kategori', 'suratMasuk'])->where('jenis_surat', 'surat_masuk');
        $querySuratKeluar = Dokumen::with(['kategori', 'suratKeluar'])->where('jenis_surat', 'surat_keluar');

        // Filter berdasarkan periode
        switch ($this->periode) {
            case 'mingguan':
                if ($this->minggu && $this->tahun) {
                    $startOfWeek = Carbon::now()->setISODate($this->tahun, $this->minggu)->startOfWeek();
                    $endOfWeek = Carbon::now()->setISODate($this->tahun, $this->minggu)->endOfWeek();

                    $querySuratMasuk->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    $querySuratKeluar->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                }
                break;

            case 'bulanan':
                $querySuratMasuk->whereMonth('created_at', $this->bulan)
                                ->whereYear('created_at', $this->tahun);
                $querySuratKeluar->whereMonth('created_at', $this->bulan)
                                ->whereYear('created_at', $this->tahun);
                break;

            case 'tahunan':
                $querySuratMasuk->whereYear('created_at', $this->tahun);
                $querySuratKeluar->whereYear('created_at', $this->tahun);
                break;

            case 'custom':
                if ($this->tanggal_mulai && $this->tanggal_akhir) {
                    $querySuratMasuk->whereBetween('created_at', [$this->tanggal_mulai, $this->tanggal_akhir]);
                    $querySuratKeluar->whereBetween('created_at', [$this->tanggal_mulai, $this->tanggal_akhir]);
                }
                break;
        }

        // Get data
        $suratMasuk = $querySuratMasuk->orderBy('created_at', 'desc')->get();
        $suratKeluar = $querySuratKeluar->orderBy('created_at', 'desc')->get();

        // Hitung statistik
        $totalSuratMasuk = $suratMasuk->count();
        $totalSuratKeluar = $suratKeluar->count();

        // Generate periode text
        $periodeText = $this->getPeriodeText();

        // dd($suratMasuk, $suratKeluar);

        return view('laporan.surat.excel', [
            'suratMasuk' => $suratMasuk,
            'suratKeluar' => $suratKeluar,
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratKeluar' => $totalSuratKeluar,
            'periodeText' => $periodeText,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'CCCCCC']]],
        ];
    }

    private function getPeriodeText()
    {
        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        switch ($this->periode) {
            case 'mingguan':
                return "Minggu ke-{$this->minggu} Tahun {$this->tahun}";
            case 'bulanan':
                return $bulanNama[$this->bulan] . " {$this->tahun}";
            case 'tahunan':
                return "Tahun {$this->tahun}";
            case 'custom':
                return date('d/m/Y', strtotime($this->tanggal_mulai)) . " - " . date('d/m/Y', strtotime($this->tanggal_akhir));
            default:
                return '';
        }
    }
}
