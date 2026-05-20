<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratKeluar::with('creator');

        // Filters
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('no_surat', 'like', '%' . $request->search . '%')
                  ->orWhere('perihal', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        $suratKeluar = $query->latest()->paginate(10);

        return view('surat-keluar.index', compact('suratKeluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surat-keluar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|unique:surat_keluar,no_surat',
            'tanggal_surat' => 'required|date',
            'penerima' => 'required|string',
            'perihal' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $path = $request->file('file_lampiran')->store('surat-keluar', 'public');
            $validated['file_lampiran'] = $path;
        }

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'disetujui';
        $validated['instansi_penerima'] = $request->penerima; // Keep this as is for now or add to form later

        SuratKeluar::create($validated);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        return view('surat-keluar.edit', compact('suratKeluar'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|unique:surat_keluar,no_surat,' . $suratKeluar->id,
            'tanggal_surat' => 'required|date',
            'penerima' => 'required|string',
            'perihal' => 'required|string',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('file_lampiran')) {
            $path = $request->file('file_lampiran')->store('surat-keluar', 'public');
            $validated['file_lampiran'] = $path;
        }

        $validated['instansi_penerima'] = $request->penerima;
        $validated['status'] = 'disetujui';

        $suratKeluar->update($validated);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        if ($suratKeluar->file_lampiran) {
            Storage::disk('public')->delete($suratKeluar->file_lampiran);
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus.');
    }

    public function exportPdf(SuratKeluar $suratKeluar)
    {
        $pdf = Pdf::loadView('surat-keluar.pdf', compact('suratKeluar'));
        return $pdf->download('Surat-Keluar-' . $suratKeluar->no_surat . '.pdf');
    }

    public function exportWord(SuratKeluar $suratKeluar)
    {
        $templateProcessor = new TemplateProcessor(storage_path('app/templates/surat_keluar.docx'));
        
        $templateProcessor->setValue('no_surat', $suratKeluar->no_surat);
        $templateProcessor->setValue('tanggal_surat', $suratKeluar->tanggal_surat->format('d F Y'));
        $templateProcessor->setValue('penerima', $suratKeluar->penerima);
        $templateProcessor->setValue('perihal', $suratKeluar->perihal);
        
        $fileName = 'Surat-Keluar-' . $suratKeluar->no_surat . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'word');
        $templateProcessor->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
