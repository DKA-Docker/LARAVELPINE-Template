<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-screen text-base antialiased overflow-hidden">

    <style>
        /* BASE LAYOUT */
        .main-tracking-area { position: absolute; top: 60px; left: 0; right: 0; bottom: 0; display: flex; flex-direction: column; overflow: hidden; z-index: 1; }
        @media (min-width: 1024px) { .main-tracking-area { top: 70px; flex-direction: row; } }

        #control-sidebar {
            position: relative; width: 100%; height: 50%;
            border-t: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1); z-index: 20;
        }

        @media (min-width: 1024px) {
            #control-sidebar { width: 400px; height: 100%; border-t: none; border-l: 1px solid rgba(255, 255, 255, 0.05); }
        }

        #sidebar-toggle {
            position: absolute; background: #007bff; color: white; width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 100;
            transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        @media (max-width: 1023px) { #sidebar-toggle { top: -16px; left: 50%; transform: translateX(-50%); border-radius: 50%; } }
        @media (min-width: 1024px) { #sidebar-toggle { left: -32px; top: 20px; border-radius: 8px 0 0 8px; } }

        /* TACTICAL TAB BAR */
        .tactical-tab-container {
            display: flex; background: rgba(255,255,255,0.03);
            padding: 4px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05);
            margin: 20px 0 0 0;
        }
        .tab-btn {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 0; border-radius: 10px; transition: all 0.3s ease;
            @apply text-[10px] font-black uppercase tracking-widest opacity-40;
        }
        .tab-btn.is-active { background: #007bff; opacity: 1; color: white; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); }

        /* SEARCH FORM */
        .search-wrapper { position: relative; }
        .search-wrapper i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); opacity: 0.3; font-size: 16px; }
        #unit-search {
            width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);
            border-radius: 18px; padding: 16px 16px 16px 52px; text-[11px] font-black tracking-widest focus:outline-none focus:border-primary/50 transition-all;
        }

        /* --- CYBER SCAN EFFECTS --- */
        .sidebar-content-wrapper { position: relative; display: flex; flex-direction: column; height: 100%; overflow: hidden; }
        .cyber-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; opacity: 0; z-index: 50; transition: all 0.4s ease; }
        .is-updating .cyber-overlay { opacity: 1; background: linear-gradient(rgba(0, 123, 255, 0.05) 50%, transparent 50%); background-size: 100% 4px; }
        .is-commanding .cyber-overlay { opacity: 1; background: radial-gradient(circle at center, rgba(255, 0, 85, 0.1) 0%, rgba(255, 0, 85, 0.05) 100%); }

        .scan-line { position: absolute; width: 100%; height: 3px; background: #007bff; top: -10px; opacity: 0; z-index: 60; box-shadow: 0 0 15px #007bff; pointer-events: none; }
        @keyframes cyber-scan-move { 0% { top: 0%; opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { top: 100%; opacity: 0; } }
        .is-updating .scan-line { opacity: 1; animation: cyber-scan-move 2s linear infinite; }
        .is-commanding .scan-line { background: #ff0055; box-shadow: 0 0 20px #ff0055; animation-duration: 0.8s; }

        /* PULSE & MARKER ANIMATIONS */
        .marker-car { position: relative; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .car-icon { font-size: 45px; z-index: 10; filter: drop-shadow(0 0 10px rgba(0,0,0,0.8)); transition: all 0.4s ease; }

        /* MARKER ACTIVE STATE */
        .marker-car.is-active .car-icon {
            transform: scale(1.3) translateY(-10px);
            filter: drop-shadow(0 15px 15px rgba(0,123,255,0.6)) hue-rotate(180deg);
        }

        .pulse-ring { position: absolute; width: 60px; height: 60px; border-radius: 50%; background: rgba(0, 123, 255, 0.4); transform: scale(0); opacity: 0; pointer-events: none; }
        .marker-pulse-active .pulse-ring { animation: dramatic-pulse 2s infinite ease-out; }

        .pulse-danger { position: absolute; width: 60px; height: 60px; border-radius: 50%; background: rgba(255, 0, 85, 0.6); transform: scale(0); opacity: 0; pointer-events: none; }
        .marker-alarm-active .pulse-danger { animation: dramatic-pulse 0.8s infinite ease-out; }

        @keyframes dramatic-pulse { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(6); opacity: 0; } }

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

                <aside id="control-sidebar" class="flex flex-col shrink-0 bg-background/95 backdrop-blur-xl border-white/5 shadow-2xl">
                    <div id="sidebar-toggle"><i class="ki-filled ki-arrow-right text-sm"></i></div>

                    <div class="sidebar-content-wrapper flex flex-col h-full overflow-hidden">
                        <div class="cyber-overlay"></div>
                        <div class="scan-line"></div>

                        <div class="py-2 px-8 border-b border-white/5 relative z-[60]">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-2xl font-black tracking-tighter uppercase italic text-primary leading-none">Intelligence Hub</h2>
                                    <p class="text-[9px] opacity-40 font-black uppercase tracking-[0.4em] mt-2">Tactical Stream Active</p>
                                </div>
                            </div>

                            <div class="tactical-tab-container">
                                <button class="tab-btn" data-tab="list">
                                    <i class="ki-filled ki-row-horizontal"></i> Unit List
                                </button>
                                <button class="tab-btn" data-tab="detail">
                                    <i class="ki-filled ki-十字星"></i> Unit Info
                                </button>
                            </div>
                        </div>

                        <div class="grow overflow-hidden relative z-[60] flex flex-col">

                            <div id="tab-list" class="tab-content grow hidden flex flex-col p-8">
                                <div class="search-wrapper mb-6">
                                    <i class="ki-filled ki-magnifier"></i>
                                    <input type="text" id="unit-search" placeholder="SEARCH ACTIVE NODES..." autocomplete="off">
                                </div>
                                <div id="unit-list-container" class="grow overflow-y-auto space-y-3 pr-2">
                                    <div class="text-center py-20 opacity-20 text-[10px] font-black tracking-widest uppercase">Initializing...</div>
                                </div>
                            </div>

                            <div id="tab-detail" class="tab-content grow hidden overflow-y-auto space-y-6">
                                <div id="unit-card" class="px-8 py-2 rounded-[2.5rem] relative overflow-hidden">
                                    <div class="flex items-center gap-6">
                                        <div class="relative">
                                            <img id="unit-avatar" src="/storage/media/avatars/blank.png" class="size-20 rounded-3xl object-cover shadow-2xl">
                                            <div class="absolute inset-0 rounded-3xl animate-pulse"></div>
                                        </div>
                                        <div class="flex-1">
                                            <h4 id="unit-name" class="text-xl font-black tracking-tight italic text-foreground uppercase">System Ready</h4>
                                            <p id="unit-id" class="text-[10px] font-mono font-bold opacity-40 uppercase tracking-widest">Awaiting Link...</p>
                                        </div>
                                    </div>

                                    <div class="mt-8 grid grid-cols-2 gap-4">
                                        <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                                            <span class="block text-[9px] font-black opacity-30 mb-2 uppercase text-primary">Velocity</span>
                                            <span id="unit-speed" class="text-xl font-black italic text-foreground">0.00 <small class="text-[10px] opacity-30 not-italic font-black">KM/H</small></span>
                                        </div>
                                        <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                                            <span class="block text-[9px] font-black opacity-30 mb-2 uppercase text-primary">Sync Delay</span>
                                            <span id="unit-time" class="text-xl font-black italic text-foreground">--:--</span>
                                        </div>
                                        <div class="bg-white/5 p-5 rounded-2xl border border-white/5 col-span-2">
                                            <div class="flex justify-between items-end">
                                                <div><span class="block text-[9px] font-black opacity-30 mb-2 uppercase">Position</span><span id="unit-coords" class="text-[11px] font-mono font-black text-foreground/80 tracking-tight">0.00000, 0.00000</span></div>
                                                <div class="text-right"><span class="block text-[9px] font-black opacity-30 mb-2 uppercase">Accuracy</span><span id="unit-accuracy" class="text-xs font-mono font-black text-primary">N/A</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <button id="btn-ping-driver" class="hidden w-full mt-8 py-5 bg-primary text-white rounded-2xl font-black text-xs uppercase flex items-center justify-center gap-3 active:scale-95 shadow-xl transition-all">
                                        <div class="spinner-custom"></div><span class="btn-text tracking-[0.3em]">Execute Loc Update</span>
                                    </button>
                                    <button id="btn-alarm-driver" class="hidden w-full mt-3 py-5 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl font-black text-xs uppercase flex items-center justify-center gap-3 active:scale-95 shadow-lg transition-all hover:bg-red-500 hover:text-white group">
                                        <div class="spinner-custom"></div><i class="ki-filled ki-vibrate text-base group-hover:animate-bounce"></i><span class="btn-text tracking-[0.3em]">Initiate Unit Alarm</span>
                                    </button>
                                </div>
                                <div id="log-widget" class="hidden space-y-4 pl-8 pr-8 pb-10">
                                    <h3 class="text-[10px] font-black opacity-30 uppercase tracking-[0.5em] pl-2">Live Telemetry</h3>
                                    <div id="log-container" class="space-y-2 max-h-[350px] overflow-hidden"></div>
                                </div>
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
