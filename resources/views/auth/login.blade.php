<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SID Bawangan Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-950 min-h-screen flex items-center justify-center relative overflow-hidden selection:bg-sky-500 selection:text-white">

    {{-- Background Glow Effects --}}
    <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-sky-600/20 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] bg-emerald-600/20 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.025%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%221.5%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-70 pointer-events-none"></div>

    <div class="w-full max-w-md px-4 sm:px-6 z-10 py-12">
        {{-- Back to home button --}}
        <div class="mb-8 flex justify-center animate-fade-in-up">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-300 hover:text-white transition-all bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/15 shadow-lg hover:bg-white/20 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer focus:outline-none focus:ring-2 focus:ring-sky-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Beranda Utama</span>
            </a>
        </div>

        <div class="bg-white/95 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white p-8 sm:p-10 animate-fade-in-up animation-delay-100">
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-slate-50 rounded-2xl p-2 border border-slate-200/80 shadow-xs flex items-center justify-center">
                    <img src="{{ asset('logo/jombang.png') }}" alt="Logo Desa Bawangan"
                        class="w-full h-full object-contain">
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-1">SID BAWANGAN</h1>
                <p class="text-xs font-semibold text-slate-500">Portal Masuk Pengelola Web Desa</p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 flex items-start gap-3 text-xs font-semibold text-emerald-800 shadow-xs">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 flex items-start gap-3 text-xs font-semibold text-rose-800 shadow-xs">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="block w-full pl-11 pr-4 py-3 border border-slate-300/90 rounded-2xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all text-sm font-medium text-slate-900 placeholder-slate-400 outline-none" placeholder="admin@desabawangan.id">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input id="password" type="password" name="password" required class="block w-full pl-11 pr-11 py-3 border border-slate-300/90 rounded-2xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all text-sm font-medium text-slate-900 placeholder-slate-400 outline-none" placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none" title="Tampilkan/Sembunyikan Kata Sandi">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.973c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-sky-600 focus:ring-sky-500 border-slate-300 rounded-md cursor-pointer">
                        <label for="remember" class="ml-2 block text-xs font-semibold text-slate-600 cursor-pointer">Ingat Sesi Saya</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                        Lupa Kata Sandi?
                    </a>
                </div>

                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl font-bold text-sm text-white bg-gradient-to-r from-sky-700 via-sky-800 to-emerald-700 hover:from-sky-800 hover:to-emerald-800 shadow-xl shadow-sky-800/25 hover:shadow-sky-800/40 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>
        </div>
        
        <p class="text-center mt-8 text-xs text-slate-400">
            &copy; {{ date('Y') }} Pemerintah Desa Bawangan. Sistem Informasi Resmi.
        </p>
    </div>

    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const eyeIcon = btn.querySelector('.eye-icon');
            const eyeSlashIcon = btn.querySelector('.eye-slash-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                if (eyeIcon) eyeIcon.classList.add('hidden');
                if (eyeSlashIcon) eyeSlashIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                if (eyeIcon) eyeIcon.classList.remove('hidden');
                if (eyeSlashIcon) eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>

