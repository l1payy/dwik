<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 rounded-2xl">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Edit Surat Masuk</h2>
                            <p class="text-sm text-gray-500 mt-1">Perbarui informasi untuk surat nomor <span class="text-primary font-bold">{{ $suratMasuk->no_surat }}</span>.</p>
                        </div>
                        <a href="{{ route('surat-masuk.index') }}" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>

                    <form action="{{ route('surat-masuk.update', $suratMasuk) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- No Surat -->
                            <div class="space-y-2">
                                <label for="no_surat" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Nomor Surat</label>
                                <input type="text" name="no_surat" id="no_surat" value="{{ old('no_surat', $suratMasuk->no_surat) }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all">
                                <x-input-error :messages="$errors->get('no_surat')" class="mt-2" />
                            </div>

                            <!-- Tanggal Surat -->
                            <div class="space-y-2">
                                <label for="tanggal_surat" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" id="tanggal_surat" value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat->format('Y-m-d')) }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all">
                                <x-input-error :messages="$errors->get('tanggal_surat')" class="mt-2" />
                            </div>

                            <!-- Tanggal Masuk -->
                            <div class="space-y-2">
                                <label for="tanggal_masuk" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Tanggal Diterima</label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ old('tanggal_masuk', $suratMasuk->tanggal_masuk->format('Y-m-d')) }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all">
                                <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pengirim -->
                            <div class="space-y-2">
                                <label for="pengirim" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Nama Pengirim</label>
                                <input type="text" name="pengirim" id="pengirim" value="{{ old('pengirim', $suratMasuk->pengirim) }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all">
                                <x-input-error :messages="$errors->get('pengirim')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Perihal -->
                        <div class="space-y-2">
                            <label for="perihal" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Perihal</label>
                            <textarea name="perihal" id="perihal" rows="3" required
                                class="block w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all">{{ old('perihal', $suratMasuk->perihal) }}</textarea>
                            <x-input-error :messages="$errors->get('perihal')" class="mt-2" />
                        </div>

                        <!-- File Lampiran -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">File Lampiran</label>
                            @if($suratMasuk->file_lampiran)
                                <div class="flex items-center p-4 bg-orange-50 rounded-xl border border-orange-100 mb-4">
                                    <div class="p-2 bg-orange-100 rounded-lg text-primary mr-3">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-900">File Saat Ini</p>
                                        <p class="text-xs text-gray-500">{{ basename($suratMasuk->file_lampiran) }}</p>
                                    </div>
                                    <a href="{{ Storage::url($suratMasuk->file_lampiran) }}" target="_blank" class="text-xs font-bold text-primary hover:text-orange-700">Lihat File</a>
                                </div>
                            @endif
                            
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-primary transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file_lampiran" class="relative cursor-pointer bg-white rounded-md font-bold text-primary hover:text-orange-700 focus-within:outline-none">
                                            <span id="fileNameDisplay">Upload file baru</span>
                                            <input id="file_lampiran" name="file_lampiran" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB (Kosongkan jika tidak ingin mengubah)</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('file_lampiran')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('surat-masuk.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">Batal</a>
                            <button type="submit" class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-200 hover:bg-orange-700 transition-all transform hover:-translate-y-0.5">Perbarui Surat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file_lampiran');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileInput && fileNameDisplay) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                    } else {
                        fileNameDisplay.textContent = 'Upload file baru';
                    }
                });
            }
        });
    </script>
</x-app-layout>
