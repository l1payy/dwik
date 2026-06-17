<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Surat Masuk</h1>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Kelola dokumen dan surat resmi masuk ke sistem.</p>
                </div>
                @if(auth()->user()->role === 'sekretaris')
                <a href="{{ route('surat-masuk.create') }}" class="inline-flex items-center px-6 py-3 bg-primary border border-transparent rounded-xl font-black text-xs text-white uppercase tracking-widest hover:bg-orange-600 focus:bg-orange-600 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all shadow-lg shadow-primary/20 transform hover:-translate-y-0.5">
                    <svg class="h-4 w-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Surat
                </a>
                @endif
            </div>

            <div class="space-y-6">
                <!-- Filters & Search -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <form action="{{ route('surat-masuk.index') }}" method="GET" class="space-y-4">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary" placeholder="Cari berdasarkan No Surat atau Perihal...">
                            </div>
                            <div class="w-full md:w-48">
                                <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="this.form.submit()" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">No Surat</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Pengirim</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Perihal</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Disposisi</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($suratMasuk as $item)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                                <div class="text-sm font-bold text-primary">{{ $item->no_surat }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 font-medium">{{ $item->tanggal_masuk->format('d M Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $item->pengirim }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 line-clamp-2 leading-relaxed">{{ $item->perihal }}</div>
                                            </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">{{ $item->catatan ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('surat-masuk.show', $item) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Lihat">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if($item->file_lampiran)
                                            <a href="{{ Storage::url($item->file_lampiran) }}" download class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Download">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                            @endif

                                            @if(auth()->user()->role === 'sekretaris')
                                            <a href="{{ route('surat-masuk.edit', $item) }}" class="p-1.5 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            @endif

                                                @if(auth()->user()->role === 'sekretaris')
                                                <form action="{{ route('surat-masuk.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            Tidak ada data surat masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($suratMasuk->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            {{ $suratMasuk->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
