<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-32 w-auto transition-transform hover:scale-110 duration-300 drop-shadow-lg">
        </div>
        <h2 class="text-2xl font-black text-white uppercase tracking-tight">E-Surat BPBD</h2>
        <p class="text-sm text-white/80 mt-1 font-medium">Sistem Informasi Manajemen Surat & Dokumen</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase tracking-wider text-white/90" />
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-white/50 group-focus-within:text-white transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full pl-11 pr-4 py-3 bg-white/10 border-white/20 rounded-xl text-sm text-white placeholder-white/40 focus:ring-white focus:border-white transition-all"
                    placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-white bg-red-500/50 rounded-lg px-2 py-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase tracking-wider text-white/90" />
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-white/50 group-focus-within:text-white transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3 bg-white/10 border-white/20 rounded-xl text-sm text-white placeholder-white/40 focus:ring-white focus:border-white transition-all"
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-white bg-red-500/50 rounded-lg px-2 py-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between py-1">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-white/30 text-primary bg-white shadow-sm focus:ring-white transition-all cursor-pointer" name="remember">
                <span class="ms-2.5 text-xs font-bold text-white/80 uppercase tracking-wider group-hover:text-white transition-colors">Ingat Saya</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-xl text-sm font-black text-primary bg-white hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-all transform hover:-translate-y-0.5 active:scale-95 uppercase tracking-widest">
                Login
            </button>
        </div>
    </form>
</x-guest-layout>
