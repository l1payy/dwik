<nav class="navbar bg-[#E67725] border-b border-white/10 fixed top-0 left-0 right-0 z-[9999]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center group">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-10 w-auto rounded-lg shadow-md group-hover:scale-110 transition-transform">
                    <span class="ml-3 text-lg font-black text-white uppercase tracking-tighter">E-Surat</span>
                </a>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex h-full items-center">
                    <a href="{{ route('dashboard') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'text-white' : 'text-white/70 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('surat-masuk.index') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('surat-masuk.*') ? 'text-white' : 'text-white/70 hover:text-white' }}">
                        Surat Masuk
                    </a>
                    <a href="{{ route('surat-keluar.index') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('surat-keluar.*') ? 'text-white' : 'text-white/70 hover:text-white' }}">
                        Surat Keluar
                    </a>
                    @if(Auth::user()->role === 'pimpinan' || Auth::user()->role === 'sekretaris')
                    <a href="{{ route('laporan.index') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('laporan.*') ? 'text-white' : 'text-white/70 hover:text-white' }}">
                        Laporan
                    </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Notifications Button -->
                <button id="notifToggleBtn" class="relative p-3 text-white/90 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/40">
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

                <!-- Profile Dropdown -->
                <div class="relative group">
                    <button id="profileToggleBtn" class="flex items-center space-x-3 focus:outline-none cursor-pointer py-2 px-3 rounded-2xl hover:bg-white/10 transition-all duration-200">
                        <div class="text-right hidden md:block">
                            <div class="text-xs font-black text-white leading-tight">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-white/70 uppercase tracking-widest font-bold">{{ Auth::user()->role }}</div>
                        </div>
                        <div class="h-10 w-10 rounded-xl bg-white text-[#E67725] flex items-center justify-center text-sm font-black shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>
                    <div id="profileDropdown" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 z-[99999] hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-t-xl transition-colors">
                            Profile
                        </a>
                        <a href="{{ route('profile.edit') }}#update-password" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Ubah Password
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 rounded-b-xl transition-colors">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button id="mobileMenuBtn" class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/10 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="sm:hidden bg-white hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-900 {{ request()->routeIs('dashboard') ? 'bg-gray-50' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('surat-masuk.index') }}" class="block px-4 py-2 text-base font-medium text-gray-900 {{ request()->routeIs('surat-masuk.*') ? 'bg-gray-50' : '' }}">
                Surat Masuk
            </a>
            <a href="{{ route('surat-keluar.index') }}" class="block px-4 py-2 text-base font-medium text-gray-900 {{ request()->routeIs('surat-keluar.*') ? 'bg-gray-50' : '' }}">
                Surat Keluar
            </a>
            @if(Auth::user()->role === 'pimpinan' || Auth::user()->role === 'sekretaris')
            <a href="{{ route('laporan.index') }}" class="block px-4 py-2 text-base font-medium text-gray-900 {{ request()->routeIs('laporan.*') ? 'bg-gray-50' : '' }}">
                Laporan
            </a>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-900">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-red-600">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Notification Panel -->
<div id="notifPanel" class="fixed inset-0 z-[99999] hidden">
    <div id="notifBackdrop" class="absolute inset-0 bg-gray-500 bg-opacity-75"></div>
    <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
        <div class="w-screen max-w-md bg-white shadow-2xl">
            <div class="h-full flex flex-col">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-[#E67725]">
                    <h2 class="text-lg font-black text-white uppercase tracking-tighter">Notifikasi</h2>
                    <button id="notifCloseBtn" class="text-white hover:text-white/80 transition-colors p-1">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                    @forelse(\App\Models\Notifikasi::where('user_id', Auth::id())->latest()->limit(10)->get() as $notif)
                        <div class="flex items-start p-4 rounded-2xl border {{ !$notif->is_read ? 'bg-white border-orange-200 shadow-sm' : 'bg-white border-gray-100' }}">
                            <div class="shrink-0 {{ $notif->tipe == 'surat_masuk' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-[#E67725]' }} p-2.5 rounded-xl">
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
                                        <span class="w-2 h-2 bg-[#E67725] rounded-full"></span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $notif->pesan }}</p>
                                <p class="text-[10px] text-gray-400 mt-2 uppercase font-black tracking-widest">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center p-8">
                            <div class="p-6 bg-white rounded-3xl shadow-sm border border-gray-100 mb-4">
                                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <button type="submit" class="w-full py-4 bg-[#E67725] text-white text-xs font-black rounded-xl hover:bg-orange-700 transition-all uppercase tracking-widest">
                            Tandai Semua Sudah Dibaca
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vanilla JavaScript for Navbar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Notification Panel Toggle
    const notifToggleBtn = document.getElementById('notifToggleBtn');
    const notifPanel = document.getElementById('notifPanel');
    const notifBackdrop = document.getElementById('notifBackdrop');
    const notifCloseBtn = document.getElementById('notifCloseBtn');

    function openNotif() {
        notifPanel.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeNotif() {
        notifPanel.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (notifToggleBtn) notifToggleBtn.addEventListener('click', openNotif);
    if (notifBackdrop) notifBackdrop.addEventListener('click', closeNotif);
    if (notifCloseBtn) notifCloseBtn.addEventListener('click', closeNotif);

    // 2. Profile Dropdown Toggle
    const profileToggleBtn = document.getElementById('profileToggleBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    function toggleProfile() {
        if (profileDropdown.classList.contains('hidden')) {
            profileDropdown.classList.remove('hidden');
        } else {
            profileDropdown.classList.add('hidden');
        }
    }

    if (profileToggleBtn) profileToggleBtn.addEventListener('click', toggleProfile);

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (profileToggleBtn && profileDropdown) {
            if (!profileToggleBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        }
    });

    // 3. Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    function toggleMobileMenu() {
        mobileMenu.classList.toggle('hidden');
    }

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', toggleMobileMenu);
});
</script>
