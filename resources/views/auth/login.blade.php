<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-24 w-auto rounded-2xl shadow-lg border-2 border-primary/20 p-1">
        </div>
        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">E-Surat BPBD</h2>
        <p class="text-sm text-gray-500 mt-1 font-medium">Sistem Informasi Manajemen Surat & Dokumen</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase tracking-wider text-gray-600" />
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                    class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all placeholder-gray-400"
                    placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase tracking-wider text-gray-600" />
                @if (Route::has('password.request'))
                    <a class="text-[11px] font-bold text-primary hover:text-orange-700 transition-colors uppercase tracking-wider" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl text-sm focus:ring-primary focus:border-primary transition-all placeholder-gray-400"
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between py-1">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary shadow-sm focus:ring-primary transition-all cursor-pointer" name="remember">
                <span class="ms-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider group-hover:text-gray-700 transition-colors">Ingat Saya</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary/20 text-sm font-black text-white bg-primary hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform hover:-translate-y-0.5 active:scale-95 uppercase tracking-widest">
                Masuk ke Sistem
            </button>
        </div>
    </form>
</x-guest-layout>
