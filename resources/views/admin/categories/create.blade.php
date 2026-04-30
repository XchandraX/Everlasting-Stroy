@extends('layouts.admin')

@section('admin_content')
<div class="fade-up max-w-4xl mx-auto">
    <div class="mb-10 flex justify-between items-end">
        <div>
            <p class="text-[10px] text-cyan-500 font-mono tracking-[0.5em] mb-1">// NODE_INITIALIZATION</p>
            <h2 class="text-3xl font-black italic text-white uppercase tracking-tighter">Create<span class="text-cyan-400">_Category</span></h2>
            <div class="h-1 w-20 bg-cyan-500 mt-2 shadow-[0_0_10px_rgba(6,182,212,0.5)]"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-black/40 backdrop-blur-md border border-white/5 p-8 rounded-3xl relative overflow-hidden">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-mono text-cyan-500 uppercase tracking-widest mb-2">Category_Name</label>
                        <input type="text" name="nama_kategori" placeholder="E.G. MOMENTS_IN_TOKYO" required 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500/50 outline-none transition font-mono text-sm">
                    </div>

                    <div>
                        <label class="block text-[10px] font-mono text-cyan-500 uppercase tracking-widest mb-2">Cover_Access_Path</label>
                        <label for="imgUpload" class="flex items-center justify-center w-full bg-pink-600/10 border border-pink-500/30 rounded-xl px-4 py-3 cursor-pointer hover:bg-pink-600/20 transition group">
                            <i class="bi bi-camera-fill mr-2 text-pink-500"></i>
                            <span class="text-[10px] font-black text-pink-500 uppercase tracking-widest">Select_Cover_Image</span>
                            <input type="file" name="cover_image" id="imgUpload" accept="image/*" required class="hidden">
                        </label>
                    </div>

                    <div class="pt-6 flex gap-4">
                        <button type="submit" class="flex-1 bg-cyan-500 text-black font-black py-4 rounded-xl hover:bg-cyan-400 transition uppercase text-[10px] tracking-widest">
                            Execute_Store
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="px-6 flex items-center justify-center border border-white/10 rounded-xl text-gray-500 hover:text-white transition text-[10px] font-bold">
                            ABORT
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="border border-white/10 rounded-3xl bg-black/20 flex flex-col items-center justify-center p-6 relative group overflow-hidden">
            <div id="previewContainer" class="hidden w-full h-full text-center">
                <p class="text-[9px] text-cyan-400 font-mono mb-4 uppercase tracking-[0.3em] animate-pulse">Input_Detected: Ready_to_Sync</p>
                <div class="aspect-video w-full rounded-2xl overflow-hidden border border-cyan-500/30">
                    <img id="imagePreview" class="w-full h-full object-cover">
                </div>
            </div>
            
            <div id="placeholder" class="text-center opacity-40">
                <i class="bi bi-folder-plus text-5xl mb-4 block"></i>
                <p class="text-[10px] font-mono uppercase tracking-widest">Awaiting_Visual_Data</p>
            </div>
        </div>
    </div>
</div>

<script>
    const imgUpload = document.getElementById('imgUpload');
    const imagePreview = document.getElementById('imagePreview');
    const previewContainer = document.getElementById('previewContainer');
    const placeholder = document.getElementById('placeholder');

    imgUpload.onchange = evt => {
        const [file] = imgUpload.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            previewContainer.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
    }
</script>
@endsection