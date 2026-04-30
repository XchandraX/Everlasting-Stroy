@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] px-4">
    <div class="w-full max-w-md bg-slate-900/80 backdrop-blur-xl p-8 md:p-10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black tracking-tighter text-white">
                <span class="text-cyan-400">ADMIN</span> ACCESS
            </h1>
            <p class="text-gray-400 text-xs mt-2 uppercase tracking-widest">Identify yourself to proceed</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-6 group">
                <label class="block text-[10px] font-bold uppercase text-cyan-500 mb-2 tracking-widest group-focus-within:text-pink-500 transition">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" required 
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all placeholder:text-gray-600"
                        placeholder="admin@nexus.com">
                </div>
            </div>

            <div class="mb-10 group">
                <label class="block text-[10px] font-bold uppercase text-cyan-500 mb-2 tracking-widest group-focus-within:text-pink-500 transition">Security Password</label>
                <div class="relative">
                    <input type="password" name="password" required 
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-all placeholder:text-gray-600"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full relative group overflow-hidden bg-cyan-600 text-white py-4 rounded-xl font-black uppercase tracking-widest text-sm transition-all hover:bg-cyan-500 shadow-[0_0_20px_rgba(6,182,212,0.3)] active:scale-95">
                <span class="relative z-10">Authorize Access</span>
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-cyan-600 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>
        </form>
    </div>
</div>
@endsection