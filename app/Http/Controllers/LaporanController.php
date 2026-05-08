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
        $type = $request->get('type', 'surat_masuk');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        if ($type == 'surat_masuk') {
            $data = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->latest()
                ->paginate(15);
            
            // Chart Data: Jumlah surat per hari
            $chartData = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->select(DB::raw('DATE(tanggal_masuk) as date'), DB::raw('count(*) as count'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $data = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])
                ->latest()
                ->paginate(15);

            // Chart Data: Jumlah surat per hari
            $chartData = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])
                ->select(DB::raw('DATE(tanggal_surat) as date'), DB::raw('count(*) as count'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        return view('laporan.index', compact('data', 'startDate', 'endDate', 'type'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'surat_masuk');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($type == 'surat_masuk') {
            $data = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])->get();
            $title = 'Laporan Surat Masuk';
        } else {
            $data = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])->get();
            $title = 'Laporan Surat Keluar';
        }

        $pdf = Pdf::loadView('laporan.pdf', compact('data', 'type', 'title', 'startDate', 'endDate'));
        return $pdf->download('laporan-' . $type . '-' . $startDate . '-ke-' . $endDate . '.pdf');
    }

    public function exportWord(Request $request)
    {
        $type = $request->get('type', 'surat_masuk');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($type == 'surat_masuk') {
            $data = SuratMasuk::whereBetween('tanggal_masuk', [$startDate, $endDate])->get();
            $title = 'LAPORAN SURAT MASUK';
        } else {
            $data = SuratKeluar::whereBetween('tanggal_surat', [$startDate, $endDate])->get();
            $title = 'LAPORAN SURAT KELUAR';
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
            $table->addCell(3000)->addText('Pengirim', ['bold' => true]);
            $table->addCell(3000)->addText('Perihal', ['bold' => true]);

            foreach ($data as $index => $item) {
                $table->addRow();
                $table->addCell(500)->addText($index + 1);
                $table->addCell(2500)->addText($item->no_surat);
                $table->addCell(2000)->addText($item->tanggal_masuk->format('d/m/Y'));
                $table->addCell(3000)->addText($item->pengirim . "\n" . $item->instansi_pengirim);
                $table->addCell(3000)->addText($item->perihal);
            }
        } else {
            $table->addRow();
            $table->addCell(500)->addText('No', ['bold' => true]);
            $table->addCell(2500)->addText('No Surat', ['bold' => true]);
            $table->addCell(2000)->addText('Tgl Surat', ['bold' => true]);
            $table->addCell(3000)->addText('Tujuan', ['bold' => true]);
            $table->addCell(3000)->addText('Perihal', ['bold' => true]);

            foreach ($data as $index => $item) {
                $table->addRow();
                $table->addCell(500)->addText($index + 1);
                $table->addCell(2500)->addText($item->no_surat);
                $table->addCell(2000)->addText($item->tanggal_surat->format('d/m/Y'));
                $table->addCell(3000)->addText($item->penerima);
                $table->addCell(3000)->addText($item->perihal);
            }
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'laporan-' . $type . '-' . $startDate . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
