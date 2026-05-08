<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Laporan Surat</h2>
                            <p class="text-sm text-gray-500 mt-1">Filter dan unduh laporan surat masuk atau keluar.</p>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Jenis Laporan</label>
                            <select name="type" class="w-full border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary">
                                <option value="surat_masuk" {{ $type == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                <option value="surat_keluar" {{ $type == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="flex-1 bg-primary hover:bg-orange-600 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-orange-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                                Filter
                            </button>
                            @if(Auth::user()->role === 'pimpinan' || Auth::user()->role === 'sekretaris')
                            <a href="{{ route('laporan.export.pdf', ['type' => $type, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-red-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                PDF
                            </a>
                            <a href="{{ route('laporan.export.word', ['type' => $type, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                WORD
                            </a>
                            @endif
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="overflow-x-auto rounded-2xl border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">No. Surat</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $type == 'surat_masuk' ? 'Asal Surat' : 'Penerima' }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Perihal</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($data as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $item->no_surat }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($type == 'surat_masuk' ? $item->tanggal_masuk : $item->tanggal_surat)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ $type == 'surat_masuk' ? $item->pengirim : $item->penerima }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $item->perihal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full 
                                                {{ $item->status == 'selesai' || $item->status == 'disetujui' ? 'bg-green-100 text-green-700' : 
                                                   ($item->status == 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-primary') }}">
                                                {{ str_replace('_', ' ', $item->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                                <p class="text-gray-400 font-medium">Tidak ada data untuk periode ini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $data->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
