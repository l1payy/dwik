<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'surat_masuk_count' => SuratMasuk::count(),
            'surat_keluar_count' => SuratKeluar::count(),
            'unread_notif_count' => Notifikasi::where('user_id', Auth::id())->where('is_read', false)->count(),
        ];

        $type = $request->get('type', 'semua');
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $suratMasukQuery = SuratMasuk::query()
            ->select('id', 'no_surat', 'perihal', 'tanggal_surat', DB::raw("'masuk' as tipe"), 'created_at')
            ->whereYear('tanggal_surat', $year);

        $suratKeluarQuery = SuratKeluar::query()
            ->select('id', 'no_surat', 'perihal', 'tanggal_surat', DB::raw("'keluar' as tipe"), 'created_at')
            ->whereYear('tanggal_surat', $year);

        if ($month && $month != 'semua') {
            $suratMasukQuery->whereMonth('tanggal_surat', $month);
            $suratKeluarQuery->whereMonth('tanggal_surat', $month);
        }

        if ($type == 'masuk') {
            $arsip = $suratMasukQuery->latest()->paginate(10);
        } elseif ($type == 'keluar') {
            $arsip = $suratKeluarQuery->latest()->paginate(10);
        } else {
            $arsip = $suratMasukQuery->union($suratKeluarQuery)
                ->orderBy('tanggal_surat', 'desc')
                ->paginate(10);
        }

        $years = DB::table('surat_masuk')
            ->select(DB::raw('YEAR(tanggal_surat) as year'))
            ->union(DB::table('surat_keluar')->select(DB::raw('YEAR(tanggal_surat) as year')))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $recentSuratMasuk = SuratMasuk::latest()->limit(5)->get();
        $recentSuratKeluar = SuratKeluar::latest()->limit(5)->get();

        return view('dashboard', compact('stats', 'recentSuratMasuk', 'recentSuratKeluar', 'arsip', 'years', 'type', 'year', 'month'));
    }
}
