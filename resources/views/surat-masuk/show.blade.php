<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('surat-masuk.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Detail Surat Masuk</h1>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">No. Surat</label>
                        <p class="text-lg font-bold text-primary">{{ $suratMasuk->no_surat }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Tanggal Surat</label>
                        <p class="text-lg font-medium text-gray-900">{{ $suratMasuk->tanggal_surat->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Tanggal Masuk</label>
                        <p class="text-lg font-medium text-gray-900">{{ $suratMasuk->tanggal_masuk->format('d M Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Pengirim</label>
                        <p class="text-lg font-medium text-gray-900">{{ $suratMasuk->pengirim }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Perihal</label>
                        <p class="text-lg font-medium text-gray-900">{{ $suratMasuk->perihal }}</p>
                    </div>
                    @if($suratMasuk->catatan)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Catatan</label>
                            <p class="text-gray-700">{{ $suratMasuk->catatan }}</p>
                        </div>
                    @endif
                    @if($suratMasuk->file_lampiran)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">File Lampiran</label>
                            <div class="flex items-center gap-4">
                                @if(in_array(pathinfo($suratMasuk->file_lampiran, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ Storage::url($suratMasuk->file_lampiran) }}" alt="Lampiran" class="max-w-md rounded-lg border border-gray-200">
                                @elseif(pathinfo($suratMasuk->file_lampiran, PATHINFO_EXTENSION) === 'pdf')
                                    <iframe src="{{ Storage::url($suratMasuk->file_lampiran) }}" class="w-full h-96 rounded-lg border border-gray-200"></iframe>
                                @endif
                                <a href="{{ Storage::url($suratMasuk->file_lampiran) }}" download class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-orange-600 transition">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Komentar</h2>

                @if(auth()->user()->isPimpinan())
                    <form action="{{ route('surat-masuk.komentar.store', $suratMasuk) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="mb-4">
                            <label for="komentar" class="block text-sm font-semibold text-gray-500 mb-2">Tambah Komentar</label>
                            <textarea id="komentar" name="komentar" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-primary focus:border-primary" required placeholder="Tulis komentar Anda..."></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-orange-600 transition">
                            Kirim Komentar
                        </button>
                    </form>
                @endif

                <div class="space-y-4">
                    @forelse($suratMasuk->komentar as $komentar)
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <div class="flex justify-between items-start mb-2">
                                <div class="font-semibold text-gray-900">{{ $komentar->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $komentar->created_at->format('d M Y H:i') }}</div>
                            </div>
                            <p class="text-gray-700">{{ $komentar->komentar }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
