<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">Dashboard</h1>
                <p class="text-gray-500 mt-2 font-medium text-lg">Selamat datang kembali, <span class="text-primary font-bold">{{ Auth::user()->name }}</span>.</p>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Surat Masuk -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center group hover:border-primary/30 transition-all hover:shadow-xl hover:shadow-primary/5">
                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Surat Masuk</p>
                        <p class="text-3xl font-black text-gray-900">{{ $stats['surat_masuk_count'] }}</p>
                    </div>
                </div>

                <!-- Total Surat Keluar -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center group hover:border-primary/30 transition-all hover:shadow-xl hover:shadow-primary/5">
                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Surat Keluar</p>
                        <p class="text-3xl font-black text-gray-900">{{ $stats['surat_keluar_count'] }}</p>
                    </div>
                </div>

                <!-- Unread Notifications -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex items-center group hover:border-primary/30 transition-all hover:shadow-xl hover:shadow-primary/5">
                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mr-6 group-hover:scale-110 transition-transform">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Belum Dibaca</p>
                        <p class="text-3xl font-black text-gray-900">{{ $stats['unread_notif_count'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Arsip Surat Section -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-gray-50/30">
                    <div>
                        <h3 class="text-xl font-black text-gray-900 tracking-tight">Arsip Surat</h3>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Data surat masuk & keluar terdokumentasi</p>
                    </div>
                    
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3">
                        <select name="type" class="text-xs font-black uppercase tracking-widest border-gray-200 rounded-xl focus:ring-primary focus:border-primary py-2.5 pl-4 pr-10">
                            <option value="semua" {{ $type == 'semua' ? 'selected' : '' }}>Semua</option>
                            <option value="masuk" {{ $type == 'masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="keluar" {{ $type == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        <select name="year" class="text-xs font-black uppercase tracking-widest border-gray-200 rounded-xl focus:ring-primary focus:border-primary py-2.5 pl-4 pr-10">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-800 transition-all active:scale-95 shadow-lg shadow-gray-200">
                            Filter
                        </button>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">No Surat</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Perihal</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tipe</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($arsip as $item)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="px-8 py-5 text-sm font-bold text-primary group-hover:scale-105 transition-transform origin-left">{{ $item->no_surat }}</td>
                                    <td class="px-8 py-5 text-sm text-gray-600 font-medium leading-relaxed">{{ $item->perihal }}</td>
                                    <td class="px-8 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $item->tipe == 'masuk' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $item->tipe == 'masuk' ? 'bg-blue-600' : 'bg-purple-600' }}"></span>
                                            {{ $item->tipe }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-sm text-gray-500 font-bold uppercase tracking-tighter">
                                        {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Tidak ada data arsip ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($arsip->hasPages())
                    <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                        {{ $arsip->links() }}
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Surat Masuk -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col group hover:border-primary/20 transition-all">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Surat Masuk Terbaru</h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Dokumen masuk terakhir</p>
                        </div>
                        <a href="{{ route('surat-masuk.index') }}" class="p-3 bg-primary/10 text-primary rounded-xl hover:bg-primary hover:text-white transition-all">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentSuratMasuk as $surat)
                            <div class="flex items-center p-5 rounded-2xl bg-gray-50/50 border border-transparent hover:border-primary/10 hover:bg-white hover:shadow-lg hover:shadow-primary/5 transition-all group/item">
                                <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center mr-4 text-primary group-hover/item:scale-110 transition-transform">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-black text-gray-900 truncate">{{ $surat->no_surat }}</p>
                                    <p class="text-xs text-gray-500 font-medium truncate mt-0.5">{{ $surat->perihal }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-widest text-center py-8">Belum ada surat masuk.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Surat Keluar -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col group hover:border-primary/20 transition-all">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Surat Keluar Terbaru</h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Dokumen keluar terakhir</p>
                        </div>
                        <a href="{{ route('surat-keluar.index') }}" class="p-3 bg-primary/10 text-primary rounded-xl hover:bg-primary hover:text-white transition-all">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentSuratKeluar as $surat)
                            <div class="flex items-center p-5 rounded-2xl bg-gray-50/50 border border-transparent hover:border-primary/10 hover:bg-white hover:shadow-lg hover:shadow-primary/5 transition-all group/item">
                                <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center mr-4 text-primary group-hover/item:scale-110 transition-transform">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-black text-gray-900 truncate">{{ $surat->no_surat }}</p>
                                    <p class="text-xs text-gray-500 font-medium truncate mt-0.5">{{ $surat->perihal }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 font-bold uppercase tracking-widest text-center py-8">Belum ada surat keluar.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
