<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-screen text-base antialiased overflow-hidden">

    <style>
        .main-tracking-area { position: absolute; top: 60px; left: 0; right: 0; bottom: 0; display: flex; flex-direction: column; overflow: hidden; z-index: 1; }
        @media (min-width: 1024px) { .main-tracking-area { top: 70px; flex-direction: row; } }

        /* Sidebar Container */
        #control-sidebar { width: 100%; height: 50%; border-t: 1px solid rgba(255, 255, 255, 0.05); overflow: hidden; }
        @media (min-width: 1024px) { #control-sidebar { width: 400px; height: 100%; border-t: none; border-l: 1px solid rgba(255, 255, 255, 0.05); } }

        /* --- CYBER SCANNER SYSTEM --- */
        .cyber-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; opacity: 0; z-index: 50;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .is-updating .cyber-overlay {
            opacity: 1;
            background: linear-gradient(rgba(0, 123, 255, 0.05) 50%, transparent 50%);
            background-size: 100% 4px;
        }

        .is-commanding .cyber-overlay {
            opacity: 1 !important;
            background: radial-gradient(circle at center, rgba(255, 0, 85, 0.2) 0%, rgba(255, 0, 85, 0.1) 100%) !important;
            background-size: 100% 100% !important;
            box-shadow: inset 0 0 100px rgba(255, 0, 85, 0.2);
        }

        .scan-line { position: absolute; width: 100%; height: 3px; background: #007bff; top: -10px; opacity: 0; z-index: 60; box-shadow: 0 0 15px #007bff; pointer-events: none; }
        @keyframes cyber-scan-move { 0% { top: 0%; opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { top: 100%; opacity: 0; } }

        .is-updating .scan-line { opacity: 1; animation: cyber-scan-move 2.5s linear infinite; }
        .is-commanding .scan-line {
            background: #ff0055 !important;
            box-shadow: 0 0 25px 5px #ff0055 !important;
            animation-duration: 0.8s !important;
        }

        /* --- DRAMATIC MARKER PULSE --- */
        .marker-car { position: relative; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; }
        .car-icon { font-size: 45px; z-index: 10; filter: drop-shadow(0 0 10px rgba(0,0,0,0.8)); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }

        /* REVISI: Marker Terpilih (Active State) */
        .marker-car.is-active .car-icon {
            transform: scale(1.3) translateY(-10px);
            filter: drop-shadow(0 15px 15px rgba(0,123,255,0.5)) hue-rotate(180deg); /* Berubah warna ke biru/cyan */
        }
        .marker-car.is-active::after {
            content: ''; position: absolute; bottom: 5px; width: 20px; height: 10px;
            background: rgba(0,0,0,0.2); border-radius: 50%; filter: blur(4px);
        }

        .pulse-ring { position: absolute; width: 60px; height: 60px; border-radius: 50%; background: rgba(0, 123, 255, 0.4); transform: scale(0); opacity: 0; pointer-events: none; z-index: 1; }
        .pulse-danger { position: absolute; width: 60px; height: 60px; border-radius: 50%; background: rgba(255, 0, 85, 0.6); transform: scale(0); opacity: 0; pointer-events: none; z-index: 2; display: none; }

        .marker-pulse-active .pulse-ring { display: block; animation: dramatic-pulse 2s infinite ease-out; }
        .marker-alarm-active .pulse-danger { display: block; animation: dramatic-pulse-danger 0.8s infinite cubic-bezier(0.24, 0, 0.38, 1); }
        .marker-alarm-active .car-icon { transform: scale(1.5); filter: drop-shadow(0 0 25px #ff0055) !important; }

        @keyframes dramatic-pulse { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(6); opacity: 0; } }
        @keyframes dramatic-pulse-danger { 0% { transform: scale(1); opacity: 1; box-shadow: 0 0 30px #ff0055; } 100% { transform: scale(8); opacity: 0; box-shadow: 0 0 60px 40px rgba(255, 0, 85, 0); } }

        .spinner-custom { display: none; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .is-loading .spinner-custom { display: block; }
    </style>

    <div class="flex grow h-full">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")
        <div class="kt-wrapper flex flex-1 flex-col h-full min-w-0 relative">
            @livewire("metronic.dashboards.layouts.constructors.headers")

            <div class="main-tracking-area">
                <div class="map-container-wrapper bg-black flex-1 relative">
                    <div id="map" class="w-full h-full"></div>
                </div>

                <aside id="control-sidebar" class="flex flex-col shrink-0 z-20 bg-background/95 backdrop-blur-xl relative border-l border-white/5 shadow-2xl">
                    <div class="cyber-overlay"></div>
                    <div class="scan-line"></div>

                    <div class="p-8 border-b border-white/5 relative z-[60]">
                        <h2 class="text-2xl font-black tracking-tighter uppercase italic text-primary">Intelligence Hub</h2>
                        <p class="text-[10px] opacity-50 font-black uppercase tracking-[0.3em]">Tactical Stream Active</p>
                    </div>

                    <div class="grow overflow-y-auto pl-8 pr-8 space-y-4 relative z-[60]">
                        <div id="unit-card" class="p-8 rounded-[2.5rem] border border-white/10 bg-white/[0.02] relative overflow-hidden">
                            <div class="flex items-center gap-6">
                                <img id="unit-avatar" src="/storage/media/avatars/blank.png" class="size-20 rounded-full border-2 border-white/20 object-cover shadow-2xl">
                                <div class="flex-1">
                                    <h4 id="unit-name" class="text-xl font-black tracking-tight italic text-foreground uppercase">System Ready</h4>
                                    <p id="unit-id" class="text-[10px] font-mono font-bold opacity-40 uppercase tracking-widest">Awaiting Link...</p>
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-2 gap-4">
                                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                                    <span class="block text-[9px] font-black opacity-30 mb-2 uppercase text-primary">Velocity</span>
                                    <span id="unit-speed" class="text-xl font-black italic text-foreground">0.00 <small class="text-xs opacity-30 font-bold not-italic font-black">KM/H</small></span>
                                </div>
                                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                                    <span class="block text-[9px] font-black opacity-30 mb-2 uppercase">Sync Delay</span>
                                    <span id="unit-time" class="text-xl font-black italic text-foreground">--:--</span>
                                </div>
                                <div class="bg-white/5 p-5 rounded-2xl border border-white/5 col-span-2">
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <span class="block text-[9px] font-black opacity-30 mb-2 uppercase">Position</span>
                                            <span id="unit-coords" class="text-[12px] font-mono font-black text-foreground/80 tracking-tight">0.00000, 0.00000</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="block text-[9px] font-black opacity-30 mb-2 uppercase">Accuracy</span>
                                            <span id="unit-accuracy" class="text-xs font-mono font-black text-primary">N/A</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button id="btn-ping-driver" class="hidden w-full mt-8 py-5 bg-primary text-white rounded-[1.5rem] font-black text-xs uppercase flex items-center justify-center gap-3 active:scale-95 shadow-xl transition-all">
                                <div class="spinner-custom"></div>
                                <span class="btn-text tracking-[0.3em]">Execute Loc Update</span>
                            </button>
                            <button id="btn-alarm-driver" class="hidden w-full mt-3 py-5 bg-red-500/10 border border-red-500/20 text-red-500 rounded-[1.5rem] font-black text-xs uppercase flex items-center justify-center gap-3 active:scale-95 shadow-lg transition-all hover:bg-red-500 hover:text-white group">
                                <div class="spinner-custom"></div>
                                <i class="ki-filled ki-vibrate text-base group-hover:animate-bounce"></i>
                                <span class="btn-text tracking-[0.3em]">Initiate Unit Alarm</span>
                            </button>
                        </div>

                        <div id="log-widget" class="hidden space-y-4">
                            <h3 class="text-[10px] font-black opacity-30 uppercase tracking-[0.5em] pl-2">Live Telemetry</h3>
                            <div id="log-container" class="space-y-2 max-h-[250px] overflow-hidden"></div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <div class="dashboards-apps-trackings"></div>
    </body>
</x-metronic.dashboards.layouts.container>
