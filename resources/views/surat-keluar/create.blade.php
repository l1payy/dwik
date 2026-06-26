<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-2xl">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Buat Surat Keluar</h2>
                            <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah untuk membuat draf surat keluar baru.</p>
                        </div>
                        <a href="{{ route('surat-keluar.index') }}" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>

                    <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <!-- ERROR DISPLAY -->
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <strong class="font-bold">Oops! Ada kesalahan:</strong>
                                <ul class="list-disc pl-5 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Row 1: No Surat & Tanggal Surat -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="no_surat" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Nomor Surat</label>
                                <input type="text" name="no_surat" id="no_surat" value="{{ old('no_surat') }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all"
                                    placeholder="Contoh: 001/KL/2026">
                                <x-input-error :messages="$errors->get('no_surat')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <label for="tanggal_surat" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all">
                                <x-input-error :messages="$errors->get('tanggal_surat')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 2: Ditujukan Kepada -->
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label for="penerima" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Ditujukan Kepada</label>
                                <input type="text" name="penerima" id="penerima" value="{{ old('penerima') }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all"
                                    placeholder="Contoh: Kepala Dinas Sosial">
                                <x-input-error :messages="$errors->get('penerima')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Perihal -->
                        <div class="space-y-2">
                            <label for="perihal" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Perihal</label>
                            <textarea name="perihal" id="perihal" rows="3" required
                                class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="Tuliskan perihal surat di sini...">{{ old('perihal') }}</textarea>
                            <x-input-error :messages="$errors->get('perihal')" class="mt-2" />
                        </div>

                        <!-- File Lampiran - SAMA PERSIS DENGAN SURAT MASUK -->
                        <div class="space-y-2">
                            <label for="file_lampiran" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Draft Dokumen (PDF)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-[#E67725] transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file_lampiran" class="relative cursor-pointer bg-white rounded-md font-bold text-[#E67725] hover:text-orange-700 focus-within:outline-none">
                                            <span id="fileNameDisplay">Upload a file</span>
                                            <input id="file_lampiran" name="file_lampiran" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, JPG, PNG up to 10MB</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('file_lampiran')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('surat-keluar.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">Batal</a>
                            <button type="submit" class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-200 hover:bg-orange-700 transition-all transform hover:-translate-y-0.5">Simpan Surat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Script untuk menampilkan nama file di dalam kotak - SAMA PERSIS DENGAN SURAT MASUK -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file_lampiran');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileInput && fileNameDisplay) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                    } else {
                        fileNameDisplay.textContent = 'Upload a file';
                    }
                });
            }
        });
    </script>
</x-app-layout>
