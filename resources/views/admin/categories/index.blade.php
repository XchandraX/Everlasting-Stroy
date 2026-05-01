@extends('layouts.admin')

@section('admin_content')
    <div class="fade-up">
        <div class="flex justify-between items-end mb-10">
            <div>
                <p class="text-[10px] text-cyan-500 font-mono tracking-[0.5em] mb-1">// DATA_STRUCTURE</p>
                <h2 class="text-3xl font-black italic uppercase tracking-tighter">Category<span
                        class="text-pink-600">_Nodes</span></h2>
                <div class="h-1 w-20 bg-cyan-500 mt-2"></div>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="bg-pink-600 hover:bg-pink-500 text-white font-black px-6 py-2 rounded-lg text-[10px] shadow-[0_0_15px_rgba(219,39,119,0.3)] transition-all hover:scale-105 active:scale-95 uppercase tracking-widest border border-pink-400/30">
                [+] Create_New_Node
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-white/10 bg-black/40 backdrop-blur-md shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Preview</th>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Node Name</th>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Asset Count</th>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] text-right">Operation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($categories as $cat)
                        <tr class="hover:bg-cyan-500/5 transition-all group">
                            <td class="px-6 py-4">
                                <div class="w-14 h-10 rounded border border-white/10 overflow-hidden bg-slate-800 group-hover:border-cyan-500/50 transition-colors">
                                    @if ($cat->cover_image)
                                        <img src="{{ $cat->cover_image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-900 text-[10px] text-gray-600">NO_IMG</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-white group-hover:text-cyan-400 transition-colors uppercase tracking-tight">{{ $cat->nama_kategori }}</span>
                                <p class="text-[9px] text-gray-600 font-mono mt-1 tracking-tighter">UUID: {{ substr(md5($cat->id), 0, 8) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="text-sm font-mono text-gray-300">{{ str_pad($cat->images_count, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="ml-2 text-[9px] text-gray-600 uppercase">Records</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-cyan-500/10 text-cyan-500 border border-cyan-500/20">
                                    <span class="w-1 h-1 bg-cyan-500 rounded-full mr-1 animate-pulse"></span> ONLINE
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.categories.edit', $cat->id) }}" class="text-gray-500 hover:text-cyan-400 transition-colors">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="delete-btn bg-transparent border-none p-0 m-0 text-gray-500 hover:text-pink-500 transition-all transform hover:scale-110">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-between items-center px-2">
            <p class="text-[9px] font-mono text-gray-600 uppercase tracking-widest">
                System_Output: {{ count($categories) }} Nodes active in cluster
            </p>
            <div class="flex gap-1">
                <div class="w-1 h-1 bg-cyan-500"></div>
                <div class="w-1 h-1 bg-cyan-500 opacity-50"></div>
                <div class="w-1 h-1 bg-cyan-500 opacity-20"></div>
            </div>
        </div>
    </div>
@endsection
