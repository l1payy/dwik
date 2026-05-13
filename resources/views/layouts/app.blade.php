<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50/50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-[#E67725] text-white pt-16 pb-8 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                        <!-- Brand Section -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-12 w-auto">
                                <span class="text-lg font-black uppercase tracking-tighter">BPBD KOTA BINJAI</span>
                            </div>
                            <div class="space-y-4">
                                <h3 class="text-sm font-black uppercase tracking-widest">Tentang Kami</h3>
                                <p class="text-sm text-white/70 leading-relaxed font-medium">
                                    Badan Penanggulangan Bencana Daerah (BPBD) Kota Binjai menyelenggarakan urusan penanggulangan bencana mulai dari pra-bencana, saat bencana, hingga pasca-bencana.
                                </p>
                            </div>
                        </div>

                        <!-- Contact Section -->
                        <div class="space-y-6">
                            <h3 class="text-sm font-black uppercase tracking-widest">Hubungi Kami</h3>
                            <div class="space-y-4 text-sm text-white/70 font-medium leading-relaxed">
                                <p>Jl. Diponegoro No.113, Mencirim, Kec. Binjai Tim., Kota Binjai, Sumatera Utara 20351</p>
                                <p>Telp: 061-8821935<br>Email: bpbdkotabinjai@gmail.com</p>
                                <a href="https://www.google.com/maps/search/?api=1&query=BPBD+Kota+Binjai" target="_blank" class="inline-flex items-center text-white hover:underline">
                                    Lihat di Maps
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Social & Links -->
                        <div class="grid grid-cols-2 gap-8 md:col-span-1">
                            <div class="space-y-6">
                                <h3 class="text-sm font-black uppercase tracking-widest">Sosial Media</h3>
                                <ul class="space-y-3 text-sm text-white/70 font-medium">
                                    <li><a href="#" class="hover:text-white transition-colors">Instagram</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Youtube</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Facebook</a></li>
                                </ul>
                            </div>
                            <div class="space-y-6">
                                <h3 class="text-sm font-black uppercase tracking-widest">Link Terkait</h3>
                                <ul class="space-y-3 text-sm text-white/70 font-medium">
                                    <li><a href="https://binjaikota.go.id" target="_blank" class="hover:text-white transition-colors">Pemko Binjai</a></li>
                                    <li><a href="https://bnpb.go.id" target="_blank" class="hover:text-white transition-colors">BNPB</a></li>
                                    <li><a href="#" class="hover:text-white transition-colors">Layanan Digital</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Map Section -->
                        <div class="space-y-6">
                            <h3 class="text-sm font-black uppercase tracking-widest">Lokasi BPBD Kota Binjai</h3>
                            <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 h-48 bg-gray-200 relative group">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.123456789!2d98.5085!3d3.6062!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031267890abcdef%3A0x1234567890abcdef!2sBPBD%20Kota%20Binjai!5e0!3m2!1sid!2sid!4v1715560000000!5m2!1sid!2sid" 
                                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="pt-8 border-t border-white/10 text-center">
                        <p class="text-xs font-bold text-white/50 uppercase tracking-[0.2em]">
                            © Copyright 2026 • BPBD Kota Binjai
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Toast Notification Container -->
        <div class="fixed bottom-0 right-0 p-6 z-[60] pointer-events-none space-y-4 max-w-sm w-full">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="translate-y-2 opacity-0"
                     x-transition:enter-end="translate-y-0 opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="translate-y-0 opacity-100"
                     x-transition:leave-end="translate-y-2 opacity-0"
                     class="bg-white border-l-4 rounded-xl shadow-2xl p-4 pointer-events-auto flex items-start space-x-4"
                     :class="toast.type === 'surat_masuk' ? 'border-blue-500' : (toast.type === 'disposisi' ? 'border-orange-500' : 'border-green-500')">
                    
                    <div class="shrink-0 p-2 rounded-lg"
                         :class="toast.type === 'surat_masuk' ? 'bg-blue-50 text-blue-600' : (toast.type === 'disposisi' ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600')">
                        <svg x-show="toast.type === 'surat_masuk'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <svg x-show="toast.type === 'disposisi'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        <svg x-show="toast.type !== 'surat_masuk' && toast.type !== 'disposisi'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900" x-text="toast.title"></p>
                        <p class="text-xs text-gray-500 mt-1" x-text="toast.message"></p>
                    </div>

                    <button @click="removeToast(toast.id)" class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </template>
        </div>

        @stack('scripts')
        <script>
            function notificationHandler() {
                return {
                    toasts: [],
                    init() {
                        const userId = {{ Auth::id() }};
                        
                        if (window.Echo) {
                            window.Echo.private(`notifications.${userId}`)
                                .listen('.notifikasi.sent', (e) => {
                                    this.addToast(e.notifikasi);
                                    // Update unread count if possible or just refresh
                                    // For now, let's just show the toast
                                });
                        }
                    },
                    addToast(notif) {
                        const id = Date.now();
                        this.toasts.push({
                            id: id,
                            title: notif.judul,
                            message: notif.pesan,
                            type: notif.tipe,
                            show: true
                        });

                        setTimeout(() => {
                            this.removeToast(id);
                        }, 10000);
                    },
                    removeToast(id) {
                        const index = this.toasts.findIndex(t => t.id === id);
                        if (index > -1) {
                            this.toasts[index].show = false;
                            setTimeout(() => {
                                this.toasts = this.toasts.filter(t => t.id !== id);
                            }, 300);
                        }
                    }
                }
            }
        </script>
    </body>
</html>
