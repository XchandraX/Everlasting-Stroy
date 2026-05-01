@extends('layouts.admin')

@section('admin_content')
    <div class="fade-up max-w-5xl mx-auto">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <p class="text-[10px] text-pink-600 font-mono tracking-[0.5em] mb-1">// NEW_DATA_INJECTION</p>
                <h2 class="text-3xl font-black italic text-white uppercase tracking-tighter">Upload<span
                        class="text-cyan-400">_Asset</span></h2>
                <div class="h-1 w-20 bg-pink-600 mt-2 shadow-[0_0_10px_rgba(219,39,119,0.5)]"></div>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-[9px] text-gray-600 font-mono uppercase">System_Status</p>
                <p class="text-[10px] text-cyan-500 font-mono animate-pulse">● UPLINK_ACTIVE</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7">
                <div
                    class="bg-black/40 backdrop-blur-md border border-white/5 p-8 rounded-3xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-pink-600/5 -mr-8 -mt-8 rotate-45"></div>

                    <form action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-[10px] font-mono text-pink-500 uppercase tracking-[0.2em] mb-2">Asset_Title</label>
                                <input type="text" name="title" placeholder="IDENTIFY_THIS_DATA..." required
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500/50 focus:ring-1 focus:ring-pink-500/20 outline-none transition font-mono text-sm">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-[10px] font-mono text-pink-500 uppercase tracking-[0.2em] mb-2">Target_Node</label>
                                    <div class="relative">
                                        <select name="kategori_id" required
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-cyan-500/50 outline-none transition font-mono text-sm appearance-none">
                                            <option value="" class="bg-slate-900 italic">-- SELECT_CLUSTER --</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" class="bg-slate-900">
                                                    {{ strtoupper($cat->nama_kategori) }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-mono text-pink-500 uppercase tracking-[0.2em] mb-2">Data_Stream</label>
                                    <label for="fileUpload"
                                        class="flex items-center justify-center w-full bg-cyan-500/10 border border-cyan-500/30 rounded-xl px-4 py-3 cursor-pointer hover:bg-cyan-500/20 transition group">
                                        <i class="bi bi-upload mr-2 text-cyan-500"></i>
                                        <span
                                            class="text-[10px] font-black text-cyan-500 uppercase tracking-widest">Select_File</span>
                                        <input type="file" name="files[]" id="fileUpload" accept="image/*,video/*"
                                            multiple required class="hidden">
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-mono text-pink-500 uppercase tracking-[0.2em] mb-2">Description_Log</label>
                                <textarea name="description" rows="4" placeholder="ADD_METADATA_DESCRIPTION..."
                                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:border-pink-500/50 outline-none transition font-mono text-xs leading-relaxed"></textarea>
                            </div>

                            <div class="pt-4 flex gap-4">
                                <button type="submit"
                                    class="flex-[2] bg-pink-600 text-white font-black py-4 rounded-xl hover:bg-pink-500 shadow-[0_0_25px_rgba(219,39,119,0.3)] transition-all active:scale-95 uppercase text-[10px] tracking-[0.3em]">
                                    Transmit_Data_Stream
                                </button>
                                <a href="{{ route('admin.images.index') }}"
                                    class="flex-1 flex items-center justify-center border border-white/10 rounded-xl text-gray-500 hover:text-white hover:bg-white/5 transition uppercase text-[10px] font-bold tracking-widest">
                                    Abort
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-5 h-full min-h-[400px]">
                <div
                    class="h-full border border-white/10 rounded-3xl bg-black/20 flex flex-col items-center justify-start p-6 relative overflow-hidden group backdrop-blur-sm">
                    <!-- Efek garis latar (tetap) -->
                    <div
                        class="absolute inset-0 pointer-events-none bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] bg-[length:100%_2px,3px_100%] z-10">
                    </div>

                    <!-- Preview Container (multiple) -->
                    <div id="previewContainer" class="hidden w-full h-full flex flex-col z-20">
                        <div class="flex justify-between items-center mb-3 px-1">
                            <div class="bg-black/80 backdrop-blur-md border border-cyan-500/50 px-2 py-1 rounded">
                                <p class="text-[8px] font-mono text-cyan-400 uppercase tracking-tighter">Media_Preview_v2.0
                                </p>
                            </div>
                            <div class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse shadow-[0_0_8px_cyan]"></div>
                        </div>

                        <div id="previewGallery"
                            class="grid grid-cols-2 gap-2 max-h-[320px] overflow-y-auto p-1 custom-scroll">
                            <!-- Thumbnail dinamis akan muncul di sini -->
                        </div>

                        <div class="mt-4 space-y-2 w-full">
                            <div class="h-1 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-cyan-500 w-full animate-[loading_2s_ease-in-out_infinite]"></div>
                            </div>
                            <p class="text-[9px] text-cyan-400 font-mono text-center tracking-[0.2em] uppercase">
                                [ Multiple_Upload_Ready ]
                            </p>
                        </div>
                    </div>

                    <!-- Placeholder awal (ketika belum pilih file) -->
                    <div id="placeholder" class="text-center z-20 group-hover:scale-110 transition-transform duration-500">
                        <div
                            class="w-20 h-20 mx-auto mb-6 rounded-full border border-dashed border-white/20 flex items-center justify-center">
                            <i class="bi bi-cpu text-3xl text-gray-700"></i>
                        </div>
                        <p class="text-[10px] text-gray-500 font-mono uppercase tracking-[0.3em]">Awaiting_Input_Signal</p>
                        <p class="text-[9px] text-gray-700 mt-2">Select multiple images (JPG/PNG)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes loading {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>

    <script>
        const fileInput = document.getElementById('fileUpload');
        const previewGallery = document.getElementById('previewGallery');
        const previewContainer = document.getElementById('previewContainer');
        const placeholder = document.getElementById('placeholder');
        

        fileInput.onchange = (evt) => {
            const files = Array.from(fileInput.files);
            if (files.length) {
                previewGallery.innerHTML = '';
                files.forEach((file, idx) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative group';

                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.className = 'w-full h-24 object-cover rounded border border-cyan-500/30';
                        wrapper.appendChild(img);
                    } else if (file.type.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.src = URL.createObjectURL(file);
                        video.className = 'w-full h-24 object-cover rounded border border-pink-500/30';
                        video.preload = 'metadata';
                        // Tampilkan frame pertama
                        video.muted = true;
                        video.onloadeddata = () => {
                            URL.revokeObjectURL(video.src);
                        };
                        // Buat poster (thumbnail) dari video
                        video.currentTime = 0.5;
                        video.onseeked = () => {
                            const canvas = document.createElement('canvas');
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;
                            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                            const posterUrl = canvas.toDataURL();
                            video.poster = posterUrl;
                            video.removeAttribute('controls');
                            video.style.objectFit = 'cover';
                        };
                        wrapper.appendChild(video);

                        // Tambahkan label "VIDEO"
                        const badge = document.createElement('div');
                        badge.innerText = 'VIDEO';
                        badge.className =
                            'absolute top-1 left-1 bg-pink-600/80 text-[8px] font-mono px-1 rounded';
                        wrapper.appendChild(badge);
                    }

                    // Nama file di bagian bawah thumbnail
                    const label = document.createElement('div');
                    label.className =
                        'absolute bottom-0 left-0 right-0 bg-black/70 text-[8px] text-cyan-300 font-mono px-1 truncate';
                    label.innerText = file.name;
                    wrapper.appendChild(label);

                    previewGallery.appendChild(wrapper);
                });
                previewContainer.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        };
    </script>
@endsection
