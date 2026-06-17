<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\KomentarSuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratMasuk::with('creator');

        // Filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('no_surat', 'like', '%' . $request->search . '%')
                  ->orWhere('perihal', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_masuk', $request->tanggal);
        }

        $suratMasuk = $query->latest()->paginate(10);

        return view('surat-masuk.index', compact('suratMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surat-masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|unique:surat_masuk,no_surat',
            'tanggal_surat' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'pengirim' => 'required|string',
            'perihal' => 'required|string',
            'catatan' => 'nullable|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $path = $request->file('file_lampiran')->store('surat-masuk', 'public');
            $validated['file_lampiran'] = $path;
        }

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'diterima';
        $validated['instansi_pengirim'] = $request->pengirim; // Fallback or handle null if migration allows

        SuratMasuk::create($validated);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('komentar.user', 'disposisi.penerima');
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    /**
     * Add comment to surat masuk (only for pimpinan).
     */
    public function addComment(Request $request, SuratMasuk $suratMasuk)
    {
        if (!Auth::user()->isPimpinan()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();
        $suratMasuk->komentar()->create($validated);

        return redirect()->route('surat-masuk.show', $suratMasuk)->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.edit', compact('suratMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|unique:surat_masuk,no_surat,' . $suratMasuk->id,
            'tanggal_surat' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'pengirim' => 'required|string',
            'perihal' => 'required|string',
            'catatan' => 'nullable|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $path = $request->file('file_lampiran')->store('surat-masuk', 'public');
            $validated['file_lampiran'] = $path;
        }

        $validated['instansi_pengirim'] = $request->pengirim;

        $suratMasuk->update($validated);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $suratMasuk)
    {
        $suratMasuk->delete();
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }

    public function exportPdf(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('disposisi.penerima');
        $pdf = Pdf::loadView('surat-masuk.disposisi-pdf', compact('suratMasuk'));
        return $pdf->download('lembar-disposisi-' . str_replace('/', '-', $suratMasuk->no_surat) . '.pdf');
    }

    public function exportWord(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('disposisi.penerima');
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Header
        $section->addText('LEMBAR DISPOSISI', ['bold' => true, 'size' => 16], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(1);

        $tableStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80];
        $phpWord->addTableStyle('DisposisiTable', $tableStyle);
        $table = $section->addTable('DisposisiTable');

        $table->addRow();
        $table->addCell(4000)->addText('No. Surat:', ['bold' => true]);
        $table->addCell(6000)->addText($suratMasuk->no_surat);

        $table->addRow();
        $table->addCell(4000)->addText('Asal Surat:', ['bold' => true]);
        $table->addCell(6000)->addText($suratMasuk->pengirim . ' - ' . $suratMasuk->instansi_pengirim);

        $table->addRow();
        $table->addCell(4000)->addText('Perihal:', ['bold' => true]);
        $table->addCell(6000)->addText($suratMasuk->perihal);

        $table->addRow();
        $table->addCell(4000)->addText('Tanggal Surat:', ['bold' => true]);
        $table->addCell(6000)->addText($suratMasuk->tanggal_surat->format('d/m/Y'));

        $section->addTextBreak(1);
        $section->addText('RIWAYAT DISPOSISI', ['bold' => true, 'size' => 12]);
        
        $dispTable = $section->addTable('DisposisiTable');
        $dispTable->addRow();
        $dispTable->addCell(500)->addText('No', ['bold' => true]);
        $dispTable->addCell(3000)->addText('Penerima', ['bold' => true]);
        $dispTable->addCell(3000)->addText('Instruksi', ['bold' => true]);
        $dispTable->addCell(3500)->addText('Catatan', ['bold' => true]);

        foreach ($suratMasuk->disposisi as $index => $d) {
            $dispTable->addRow();
            $dispTable->addCell(500)->addText($index + 1);
            $dispTable->addCell(3000)->addText($d->penerima->name);
            $dispTable->addCell(3000)->addText($d->instruksi);
            $dispTable->addCell(3500)->addText($d->catatan);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'lembar-disposisi-' . str_replace('/', '-', $suratMasuk->no_surat) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
