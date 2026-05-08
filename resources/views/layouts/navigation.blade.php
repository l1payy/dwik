<nav x-data="{ open: false, notifOpen: false }" class="bg-[#E67725] border-b border-white/10 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group">
                            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-10 w-auto rounded-lg shadow-md group-hover:scale-110 transition-transform brightness-110">
                            <span class="ml-3 text-lg font-black text-white uppercase tracking-tighter group-hover:text-white/80 transition-colors">E-Surat</span>
                        </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex h-full items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-xs font-black uppercase tracking-widest">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('surat-masuk.index')" :active="request()->routeIs('surat-masuk.*')" class="text-xs font-black uppercase tracking-widest relative">
                            {{ __('Surat Masuk') }}
                        </x-nav-link>

                    <x-nav-link :href="route('surat-keluar.index')" :active="request()->routeIs('surat-keluar.*')" class="text-xs font-black uppercase tracking-widest">
                        {{ __('Surat Keluar') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'pimpinan' || Auth::user()->role === 'sekretaris')
                    <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')" class="text-xs font-black uppercase tracking-widest">
                        {{ __('Laporan') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Search -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-1.5 border border-white/20 rounded-lg bg-white/10 text-white placeholder-white/50 text-sm focus:ring-white focus:border-white" placeholder="Cari surat...">
                </div>

                <!-- Notifications Dropdown -->
                <div class="relative" x-data="{ openNotif: false }">
                    <button @click="openNotif = !openNotif" class="relative p-2 text-white/70 hover:text-white transition-colors focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @php
                            $unreadCount = \App\Models\Notifikasi::where('user_id', Auth::id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-white text-[#E67725] text-[10px] font-bold rounded-full flex items-center justify-center ring-2 ring-[#E67725]">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <div x-show="openNotif" @click.away="openNotif = false" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden" style="display: none;">
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Notifikasi</h3>
                            <form action="{{ route('notifikasi.read-all') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold text-primary hover:underline uppercase">Tandai Semua Dibaca</button>
                            </form>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(\App\Models\Notifikasi::where('user_id', Auth::id())->latest()->limit(5)->get() as $notif)
                                <div class="p-4 border-b border-gray-50 hover:bg-gray-50/50 transition-colors {{ !$notif->is_read ? 'bg-orange-50/30' : '' }}">
                                    <div class="flex items-start">
                                        <div class="p-2 rounded-lg mr-3 {{ $notif->tipe == 'surat_masuk' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-primary' }}">
                                            @if($notif->tipe == 'surat_masuk')
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            @else
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-gray-900">{{ $notif->judul }}</p>
                                            <p class="text-[10px] text-gray-500 mt-0.5 line-clamp-2">{{ $notif->pesan }}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-medium">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <p class="text-xs text-gray-400">Tidak ada notifikasi baru.</p>
                                </div>
                            @endforelse
                        </div>
                        <a href="{{ route('notifikasi.index') }}" class="block p-3 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:bg-gray-50 transition-colors border-t border-gray-100">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-2 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <div class="text-xs font-bold text-white group-hover:text-white/80 transition-colors">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-white/60 uppercase tracking-widest">{{ Auth::user()->role }}</div>
                            </div>
                            <div class="h-9 w-9 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center text-white text-xs font-black shadow-lg backdrop-blur-sm group-hover:scale-105 transition-all">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/10 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('surat-masuk.index')" :active="request()->routeIs('surat-masuk.*')">
                {{ __('Surat Masuk') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('surat-keluar.index')" :active="request()->routeIs('surat-keluar.*')">
                {{ __('Surat Keluar') }}
            </x-responsive-nav-link>
            @if(Auth::user()->role === 'pimpinan' || Auth::user()->role === 'sekretaris')
            <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
                {{ __('Laporan') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <!-- Notification Side Panel (Overlay) -->
    <div x-show="notifOpen" 
         x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 pl-10 max-w-full flex" style="display: none;">
        <div class="w-screen max-w-md">
            <div class="h-full flex flex-col bg-white shadow-xl">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">Panel Notifikasi</h2>
                    <button @click="notifOpen = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4">
                    <!-- Sample Notifications -->
                    <div class="flex items-start p-3 bg-orange-50 rounded-lg border border-orange-100">
                        <div class="shrink-0 bg-orange-100 p-2 rounded-lg text-primary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm font-semibold text-gray-900">Surat Masuk Baru dari Sekretariat Daerah</p>
                            <p class="text-xs text-gray-500 mt-1">10 mins ago</p>
                        </div>
                    </div>
                    <!-- More notifications... -->
                </div>
                <div class="p-4 border-t border-gray-100">
                    <button class="w-full text-center text-sm font-semibold text-primary hover:text-orange-700">Tandai Semua Sudah Dibaca</button>
                </div>
            </div>
        </div>
    </div>
</nav>
