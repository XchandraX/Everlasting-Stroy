@extends('layouts.admin')

@section('admin_content')
<div class="fade-up max-w-4xl mx-auto">
    <div class="mb-10">
        <p class="text-[10px] text-pink-600 font-mono tracking-[0.5em] mb-1">// NODE_RECONFIGURATION</p>
        <h2 class="text-3xl font-black italic text-white uppercase tracking-tighter">Modify<span class="text-pink-600">_Category</span></h2>
        <div class="h-1 w-20 bg-pink-600 mt-2 shadow-[0_0_10px_rgba(219,39,119,0.5)]"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-4">
            <p class="text-[10px] font-mono text-gray-500 uppercase tracking-widest">Active_Data_Stream</p>
            <div class="relative aspect-video rounded-3xl overflow-hidden border border-white/5 bg-black/40 backdrop-blur-md">
                @if($category->cover_image)
                    <img src="{{ $category->cover_image }}" id="imagePreview" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-700 font-mono text-xs">NO_IMAGE_FOUND</div>
                @endif
                <div class="absolute bottom-6 left-6">
                    <span class="bg-pink-600 text-white text-[9px] px-2 py-1 rounded font-mono uppercase tracking-widest">Current_Node</span>
                </div>
            </div>
        </div>

        <div class="bg-black/40 backdrop-blur-md border border-white/5 p-8 rounded-3xl">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-mono text-pink-500 uppercase tracking-widest mb-2">Category_Name</label>
                        <input type="text" name="nama_kategori" value="{{ $category->nama_kategori }}" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500/50 outline-none transition font-mono text-sm">
                    </div>

                    <div>
                        <label class="block text-[10px] font-mono text-pink-500 uppercase tracking-widest mb-2">Overwrite_Cover_Data</label>
                        <label for="imgUpload" class="flex items-center justify-center w-full bg-cyan-500/10 border border-cyan-500/30 rounded-xl px-4 py-3 cursor-pointer hover:bg-cyan-500/20 transition group">
                            <i class="bi bi-arrow-repeat mr-2 text-cyan-500"></i>
                            <span class="text-[10px] font-black text-cyan-500 uppercase tracking-widest">Change_Source_File</span>
                            <input type="file" name="cover_image" id="imgUpload" accept="image/*" class="hidden">
                        </label>
                        <p class="text-[9px] text-gray-600 italic mt-2">*Leave empty to maintain existing data stream</p>
                    </div>

                    <div class="pt-6 flex gap-4">
                        <button type="submit" class="flex-1 bg-pink-600 text-white font-black py-4 rounded-xl hover:bg-pink-500 transition uppercase text-[10px] tracking-widest">
                            Apply_Changes
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="px-6 flex items-center justify-center border border-white/10 rounded-xl text-gray-500 hover:text-white transition text-[10px] font-bold uppercase tracking-widest">
                            Abort
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const imgUpload = document.getElementById('imgUpload');
    const imagePreview = document.getElementById('imagePreview');

    imgUpload.onchange = evt => {
        const [file] = imgUpload.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('opacity-70');
            imagePreview.classList.add('opacity-100');
        }
    }
</script>
@endsection
