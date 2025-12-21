<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-screen text-base antialiased overflow-hidden">

    <style>
        /* Mengubah container menjadi kolom pada mobile, dan baris pada desktop */
        .main-tracking-area {
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column; /* Default mobile: Atas (Map) - Bawah (Sidebar) */
            overflow: hidden;
            z-index: 1;
        }

        @media (min-width: 1024px) {
            .main-tracking-area {
                top: 70px;
                flex-direction: row; /* Desktop: Samping-sampingan */
            }
        }

        /* Penyesuaian ukuran Sidebar agar fleksibel di mobile */
        #control-sidebar {
            width: 100%; /* Mobile: Lebar penuh */
            height: 50%; /* Mobile: Setengah layar bawah */
            border-l: none;
            border-t: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (min-width: 1024px) {
            #control-sidebar {
                width: 400px; /* Desktop: Lebar tetap */
                height: 100%; /* Desktop: Tinggi penuh */
                border-t: none;
                border-l: 1px solid rgba(255, 255, 255, 0.1);
            }
        }

        /* Penyesuaian Map agar mengambil sisa ruang */
        .map-container-wrapper {
            flex: 1;
            min-height: 50%; /* Minimal setengah layar atas di mobile */
            position: relative;
        }

        /* MARKER 5X */
        .marker-car { font-size: 40px; cursor: pointer; transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); filter: drop-shadow(0 10px 15px rgba(0,0,0,0.4)); display: flex; align-items: center; justify-content: center; }

        /* --- ULTRA-CYBER ANIMATION SYSTEM --- */
        .cyber-overlay {
            position: absolute; inset: 0; pointer-events: none; opacity: 0; z-index: 50;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 123, 255, 0.08) 50%),
            linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            background-size: 100% 4px, 3px 100%;
            transition: opacity 0.3s ease;
        }

        .scan-line {
            position: absolute; width: 100%; height: 4px; background: #007bff;
            top: -10%; opacity: 0; z-index: 60; pointer-events: none;
            box-shadow: 0 0 20px #007bff, 0 0 40px #007bff;
        }

        @keyframes cyber-scan-move {
            0% { top: -10%; opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { top: 110%; opacity: 0; }
        }

        @keyframes cyber-pulse {
            0% { background-color: rgba(0, 123, 255, 0); }
            50% { background-color: rgba(0, 123, 255, 0.05); }
            100% { background-color: rgba(0, 123, 255, 0); }
        }

        .is-updating .cyber-overlay { opacity: 1; animation: cyber-pulse 2s infinite; }
        .is-updating .scan-line { opacity: 1; animation: cyber-scan-move 4s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite; }

        .is-commanding .scan-line {
            background: #ff0055;
            box-shadow: 0 0 20px #ff0055, 0 0 40px #ff0055;
            animation-duration: 1.5s;
        }
        .is-commanding .glass-card { border-color: #ff0055 !important; box-shadow: 0 0 50px rgba(255, 0, 85, 0.3) !important; }

        @keyframes intelligence-glow {
            0% { border-color: #007bff; box-shadow: 0 0 40px rgba(0,123,255,0.3); transform: scale(1.02); }
            100% { border-color: rgba(255, 255, 255, 0.1); transform: scale(1); }
        }
        .animate-panel-scan { animation: intelligence-glow 2s ease-out forwards; }

        .spinner-custom { display: none; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .is-loading .spinner-custom { display: block; }
        .is-loading .btn-text { opacity: 0.5; }
    </style>

    <div class="flex grow h-full">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")

        <div class="kt-wrapper flex flex-1 flex-col h-full min-w-0 relative">
            @livewire("metronic.dashboards.layouts.constructors.headers")

            <div class="main-tracking-area">
                <div class="map-container-wrapper bg-black overflow-hidden">
                    <div id="map" class="w-full h-full z-0 grayscale-[0.2]"></div>
                </div>

                <aside id="control-sidebar" class="glass-sidebar flex flex-col shadow-2xl shrink-0 z-20 bg-background/90 backdrop-blur-2xl relative overflow-hidden">

                    <div class="cyber-overlay"></div>
                    <div class="scan-line"></div>

                    <div class="p-6 border-b border-white/10 relative z-30">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-black tracking-tighter uppercase italic text-primary">Intelligence Hub</h2>
                                <p class="text-[10px] opacity-50 font-bold tracking-[0.2em] uppercase">Tactical Stream Active</p>
                            </div>
                            <div class="size-2 bg-green-500 rounded-full animate-pulse shadow-[0_0_10px_#22c55e]"></div>
                        </div>
                    </div>

                    <div class="grow overflow-y-auto p-6 space-y-6 custom-scrollbar relative z-30">
                        <div id="unit-card" class="glass-card p-6 rounded-[2.5rem] relative overflow-hidden border border-white/10 transition-all duration-500 bg-white/[0.02]">
                            <div class="flex items-center gap-5 relative z-10">
                                <div class="relative">
                                    <div id="unit-pulse" class="absolute inset-0 bg-primary/30 blur-2xl rounded-full opacity-0"></div>
                                    <img id="unit-avatar" src="{{ asset(Storage::url('media/avatars/blank.png')) }}" class="size-16 rounded-full object-cover border-2 border-white/20 relative shadow-2xl">
                                </div>
                                <div class="flex-1">
                                    <h4 id="unit-name" class="text-lg font-black tracking-tight">System Ready</h4>
                                    <p id="unit-id" class="text-[10px] font-mono opacity-40 uppercase tracking-widest">Awaiting Link...</p>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-3 relative z-10">
                                <div class="bg-white/5 p-4 rounded-2xl backdrop-blur-sm">
                                    <span class="block text-[9px] font-bold opacity-30 mb-1 uppercase tracking-tighter">Velocity</span>
                                    <span id="unit-speed" class="text-base font-black italic">0.00 <span class="text-[10px] opacity-50">KM/H</span></span>
                                </div>
                                <div class="bg-white/5 p-4 rounded-2xl backdrop-blur-sm">
                                    <span class="block text-[9px] font-bold opacity-30 mb-1 uppercase tracking-tighter">Sync Delay</span>
                                    <span id="unit-time" class="text-base font-black italic">--:--</span>
                                </div>
                            </div>

                            <button id="btn-ping-driver" class="w-full mt-6 py-4 bg-primary text-white rounded-2xl font-black text-[10px] uppercase flex items-center justify-center gap-3 transition-all active:scale-95 hover:bg-primary-hover shadow-lg shadow-primary/20">
                                <div class="spinner-custom"></div>
                                <span class="btn-text tracking-[0.2em]">Execute Loc Update</span>
                            </button>

                            <button id="btn-alarm-driver" class="w-full mt-2 py-4 bg-red-600/20 border border-red-500/30 text-red-500 rounded-2xl font-black text-[10px] uppercase flex items-center justify-center gap-3 transition-all active:scale-95 hover:bg-red-600 hover:text-white shadow-lg shadow-red-900/20">
                                <div class="spinner-custom border-red-500"></div>
                                <i class="ki-filled ki-vibrate text-sm"></i>
                                <span class="btn-text tracking-[0.2em]">Initiate Unit Alarm</span>
                            </button>

                            <div id="energy-widget" class="mt-6 pt-6 border-t border-white/10 hidden">
                                <div class="flex justify-between mb-2">
                                    <span class="text-[9px] font-bold uppercase opacity-40">System Energy Cell</span>
                                    <span id="fuel-val" class="text-[10px] font-black italic text-primary">--%</span>
                                </div>
                                <div class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                                    <div id="fuel-bar" class="h-full bg-primary transition-all duration-1000" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <div id="security-alert-box" class="hidden bg-primary/10 p-5 rounded-[2rem] backdrop-blur-md relative overflow-hidden">
                            <div class="flex gap-4 items-center relative z-10">
                                <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center animate-pulse ">
                                    <i class="ki-filled ki-radar text-primary text-xl"></i>
                                </div>
                                <div>
                                    <h5 class="text-[10px] font-black uppercase text-primary tracking-widest">Protocol Sync</h5>
                                    <p id="alert-message" class="text-[10px] leading-tight opacity-80 font-medium italic"></p>
                                </div>
                            </div>
                        </div>

                        <div id="log-widget" class="hidden space-y-4">
                            <h3 class="text-[9px] font-black opacity-30 uppercase tracking-[0.4em] pl-2">Live Telemetry</h3>
                            <div id="log-container" class="space-y-2 max-h-[250px] overflow-hidden">
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <div class="dashboards-apps-trackings"></div>
    </body>
</x-metronic.dashboards.layouts.container>
