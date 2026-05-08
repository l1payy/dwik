<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id == Auth::id()) {
            $notifikasi->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }
}
