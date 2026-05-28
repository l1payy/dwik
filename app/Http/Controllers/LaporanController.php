<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'semua');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        if ($type == 'surat_masuk') {
            $data = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->latest('tanggal_masuk')
                ->paginate(15);
        } elseif ($type == 'surat_keluar') {
            $data = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])
                ->latest('tanggal_surat')
                ->paginate(15);
        } else {
            // Semua surat (gabungan surat masuk dan keluar)
            $suratMasuk = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'no_surat' => $item->no_surat,
                        'tanggal' => $item->tanggal_masuk,
                        'pihak' => $item->pengirim,
                        'perihal' => $item->perihal,
                        'tipe' => 'Surat Masuk',
                        'created_at' => $item->created_at,
                    ];
                });

            $suratKeluar = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'no_surat' => $item->no_surat,
                        'tanggal' => $item->tanggal_surat,
                        'pihak' => $item->penerima,
                        'perihal' => $item->perihal,
                        'tipe' => 'Surat Keluar',
                        'created_at' => $item->created_at,
                    ];
                });

            $allData = $suratMasuk->concat($suratKeluar)->sortByDesc('tanggal')->values();

            // Manual pagination
            $perPage = 15;
            $currentPage = $request->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;

            $paginatedData = $allData->slice($offset, $perPage)->values();

            $data = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedData,
                $allData->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        return view('laporan.index', compact('data', 'startDate', 'endDate', 'type'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'semua');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($type == 'surat_masuk') {
            $data = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])->get();
            $title = 'Laporan Surat Masuk';
        } elseif ($type == 'surat_keluar') {
            $data = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])->get();
            $title = 'Laporan Surat Keluar';
        } else {
            // Semua surat
            $suratMasuk = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'no_surat' => $item->no_surat,
                        'tanggal' => $item->tanggal_masuk,
                        'pihak' => $item->pengirim,
                        'perihal' => $item->perihal,
                        'tipe' => 'Surat Masuk',
                    ];
                });

            $suratKeluar = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'no_surat' => $item->no_surat,
                        'tanggal' => $item->tanggal_surat,
                        'pihak' => $item->penerima,
                        'perihal' => $item->perihal,
                        'tipe' => 'Surat Keluar',
                    ];
                });

            $data = $suratMasuk->concat($suratKeluar)->sortByDesc('tanggal')->values();
            $title = 'Laporan Semua Surat';
        }

        $pdf = Pdf::loadView('laporan.pdf', compact('data', 'type', 'title', 'startDate', 'endDate'));
        return $pdf->download('laporan-' . $type . '-' . $startDate . '-ke-' . $endDate . '.pdf');
    }

    public function exportWord(Request $request)
    {
        $type = $request->get('type', 'semua');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($type == 'surat_masuk') {
            $data = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])->get();
            $title = 'LAPORAN SURAT MASUK';
        } elseif ($type == 'surat_keluar') {
            $data = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])->get();
            $title = 'LAPORAN SURAT KELUAR';
        } else {
            // Semua surat
            $suratMasuk = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'no_surat' => $item->no_surat,
                        'tanggal' => $item->tanggal_masuk,
                        'pihak' => $item->pengirim,
                        'perihal' => $item->perihal,
                        'tipe' => 'Surat Masuk',
                    ];
                });

            $suratKeluar = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'no_surat' => $item->no_surat,
                        'tanggal' => $item->tanggal_surat,
                        'pihak' => $item->penerima,
                        'perihal' => $item->perihal,
                        'tipe' => 'Surat Keluar',
                    ];
                });

            $data = $suratMasuk->concat($suratKeluar)->sortByDesc('tanggal')->values();
            $title = 'LAPORAN SEMUA SURAT';
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Header
        $headerStyle = ['bold' => true, 'size' => 14];
        $section->addText('BADAN PENANGGULANGAN BENCANA DAERAH', $headerStyle, ['alignment' => Jc::CENTER]);
        $section->addText('KOTA BINJAI', $headerStyle, ['alignment' => Jc::CENTER]);
        $section->addText($title, ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
        $section->addText('Periode: ' . date('d/m/Y', strtotime($startDate)) . ' s/d ' . date('d/m/Y', strtotime($endDate)), [], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(1);

        // Table
        $tableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
        $phpWord->addTableStyle('LaporanTable', $tableStyle);
        $table = $section->addTable('LaporanTable');

        if ($type == 'surat_masuk') {
            $table->addRow();
            $table->addCell(500)->addText('No', ['bold' => true]);
            $table->addCell(2500)->addText('No Surat', ['bold' => true]);
            $table->addCell(2000)->addText('Tgl Masuk', ['bold' => true]);
            $table->addCell(4000)->addText('Pengirim', ['bold' => true]);
            $table->addCell(4000)->addText('Perihal', ['bold' => true]);

            foreach ($data as $index => $item) {
                $table->addRow();
                $table->addCell(500)->addText($index + 1);
                $table->addCell(2500)->addText($item->no_surat);
                $table->addCell(2000)->addText($item->tanggal_masuk->format('d/m/Y'));
                $table->addCell(4000)->addText($item->pengirim . "\n" . $item->instansi_pengirim);
                $table->addCell(4000)->addText($item->perihal);
            }
        } elseif ($type == 'surat_keluar') {
            $table->addRow();
            $table->addCell(500)->addText('No', ['bold' => true]);
            $table->addCell(2500)->addText('No Surat', ['bold' => true]);
            $table->addCell(2000)->addText('Tgl Surat', ['bold' => true]);
            $table->addCell(4000)->addText('Tujuan', ['bold' => true]);
            $table->addCell(4000)->addText('Perihal', ['bold' => true]);

            foreach ($data as $index => $item) {
                $table->addRow();
                $table->addCell(500)->addText($index + 1);
                $table->addCell(2500)->addText($item->no_surat);
                $table->addCell(2000)->addText($item->tanggal_surat->format('d/m/Y'));
                $table->addCell(4000)->addText($item->penerima);
                $table->addCell(4000)->addText($item->perihal);
            }
        } else {
            // Semua surat
            $table->addRow();
            $table->addCell(500)->addText('No', ['bold' => true]);
            $table->addCell(2000)->addText('No Surat', ['bold' => true]);
            $table->addCell(1500)->addText('Tanggal', ['bold' => true]);
            $table->addCell(1500)->addText('Tipe', ['bold' => true]);
            $table->addCell(3500)->addText('Pengirim/Penerima', ['bold' => true]);
            $table->addCell(4000)->addText('Perihal', ['bold' => true]);

            foreach ($data as $index => $item) {
                $table->addRow();
                $table->addCell(500)->addText($index + 1);
                $table->addCell(2000)->addText($item->no_surat);
                $table->addCell(1500)->addText($item->tanggal->format('d/m/Y'));
                $table->addCell(1500)->addText($item->tipe);
                $table->addCell(3500)->addText($item->pihak);
                $table->addCell(4000)->addText($item->perihal);
            }
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'laporan-' . $type . '-' . $startDate . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
