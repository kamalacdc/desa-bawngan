<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi — SID Bawangan Admin</title>
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
        {{-- Back to login button --}}
        <div class="mb-8 flex justify-center animate-fade-in-up">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-300 hover:text-white transition-all bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/15 shadow-lg hover:bg-white/20 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer focus:outline-none focus:ring-2 focus:ring-sky-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Halaman Login</span>
            </a>
        </div>

        <div class="bg-white/95 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white p-8 sm:p-10 animate-fade-in-up animation-delay-100">
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-sky-50 rounded-2xl p-3 border border-sky-100 shadow-xs flex items-center justify-center text-sky-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-2">Lupa Kata Sandi?</h1>
                <p class="text-xs font-medium text-slate-500 leading-relaxed">Masukkan alamat email akun pengelola Anda. Kami akan mengirimkan petunjuk &amp; tautan untuk mereset kata sandi Anda.</p>
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

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email Terdaftar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="block w-full pl-11 pr-4 py-3 border border-slate-300/90 rounded-2xl bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all text-sm font-medium text-slate-900 placeholder-slate-400 outline-none" placeholder="admin@desabawangan.id">
                    </div>
                </div>

                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl font-bold text-sm text-white bg-gradient-to-r from-sky-700 via-sky-800 to-emerald-700 hover:from-sky-800 hover:to-emerald-800 shadow-xl shadow-sky-800/25 hover:shadow-sky-800/40 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Kirim Tautan Reset Password</span>
                </button>
            </form>
        </div>
        
        <p class="text-center mt-8 text-xs text-slate-400">
            &copy; {{ date('Y') }} Pemerintah Desa Bawangan. Sistem Informasi Resmi.
        </p>
    </div>

</body>
</html>
