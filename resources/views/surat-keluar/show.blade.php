<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('surat-keluar.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Detail Surat Keluar</h1>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">No. Surat</label>
                        <p class="text-lg font-bold text-primary">{{ $suratKeluar->no_surat }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Tanggal Surat</label>
                        <p class="text-lg font-medium text-gray-900">{{ $suratKeluar->tanggal_surat->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Penerima</label>
                        <p class="text-lg font-medium text-gray-900">{{ $suratKeluar->penerima }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Perihal</label>
                        <p class="text-lg font-medium text-gray-900">{{ $suratKeluar->perihal }}</p>
                    </div>
                    @if($suratKeluar->file_lampiran)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">File Lampiran</label>
                            <div class="flex flex-col items-center gap-4">
                                @if(in_array(pathinfo($suratKeluar->file_lampiran, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ Storage::url($suratKeluar->file_lampiran) }}" alt="Lampiran" class="max-w-md rounded-lg border border-gray-200">
                                @elseif(pathinfo($suratKeluar->file_lampiran, PATHINFO_EXTENSION) === 'pdf')
                                    <iframe src="{{ Storage::url($suratKeluar->file_lampiran) }}" class="w-full h-96 rounded-lg border border-gray-200"></iframe>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
