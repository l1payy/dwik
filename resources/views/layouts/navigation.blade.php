<nav x-data="{ open: false, notifOpen: false }" class="bg-[#E67725] border-b border-white/10 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-10 w-auto rounded-lg shadow-md group-hover:scale-110 transition-transform">
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

                <!-- Notifications Button -->
                <div class="relative">
                    <button @click="notifOpen = true" type="button" class="relative p-2 text-white/70 hover:text-white transition-colors focus:outline-none">
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
                </div>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="flex items-center space-x-3 focus:outline-none group cursor-pointer py-1 px-2 rounded-2xl hover:bg-white/10 transition-all duration-200">
                            <div class="text-right hidden md:block">
                                <div class="text-xs font-black text-white leading-tight">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] text-white/70 uppercase tracking-widest font-bold">{{ Auth::user()->role }}</div>
                            </div>
                            <div class="h-10 w-10 rounded-xl bg-white text-primary flex items-center justify-center text-sm font-black shadow-lg shadow-black/10 group-hover:scale-105 transition-all duration-200">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit') . '#update-password'">
                            {{ __('Ubah Password') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100"></div>

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
    <div x-show="notifOpen" class="fixed inset-0 z-[60]" x-cloak>
        <!-- Backdrop -->
        <div x-show="notifOpen" 
             x-transition:enter="ease-in-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="notifOpen = false"
             class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div x-show="notifOpen" 
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-md">
                <div class="h-full flex flex-col bg-white shadow-xl">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900 uppercase tracking-tighter">Notifikasi</h2>
                        <button @click="notifOpen = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50/30">
                        @forelse(\App\Models\Notifikasi::where('user_id', Auth::id())->latest()->limit(10)->get() as $notif)
                            <div class="flex items-start p-4 rounded-2xl border transition-all duration-200 {{ !$notif->is_read ? 'bg-white border-primary/20 shadow-sm ring-1 ring-primary/5' : 'bg-gray-50/50 border-gray-100' }}">
                                <div class="shrink-0 {{ $notif->tipe == 'surat_masuk' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-primary' }} p-2.5 rounded-xl">
                                    @if($notif->tipe == 'surat_masuk')
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    @else
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                    @endif
                                </div>
                                <div class="ms-4 flex-1">
                                    <div class="flex justify-between items-start">
                                        <p class="text-sm font-black text-gray-900 leading-tight">{{ $notif->judul }}</p>
                                        @if(!$notif->is_read)
                                            <span class="w-2 h-2 bg-primary rounded-full"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $notif->pesan }}</p>
                                    <p class="text-[10px] text-gray-400 mt-2 uppercase font-black tracking-widest">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center h-full text-center p-8">
                                <div class="p-6 bg-white rounded-3xl shadow-sm border border-gray-100 mb-4">
                                    <svg class="h-12 w-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                                <p class="text-sm font-black text-gray-400 uppercase tracking-widest">Tidak ada notifikasi</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="p-6 border-t border-gray-100 bg-white">
                        <form action="{{ route('notifikasi.read-all') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-primary text-white text-xs font-black rounded-2xl shadow-lg shadow-primary/20 hover:bg-orange-600 transition-all transform hover:-translate-y-0.5 uppercase tracking-widest">Tandai Semua Sudah Dibaca</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
