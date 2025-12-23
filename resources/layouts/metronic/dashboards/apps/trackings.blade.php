<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-screen text-base antialiased overflow-hidden">

    <script>
        const defaultThemeMode = 'light';
        let themeMode;
        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) { themeMode = localStorage.getItem('kt-theme'); }
            else if (document.documentElement.hasAttribute('data-kt-theme-mode')) { themeMode = document.documentElement.getAttribute('data-kt-theme-mode'); }
            else { themeMode = defaultThemeMode; }
            if (themeMode === 'system') { themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'; }
            document.documentElement.classList.add(themeMode);
        }
    </script>

    <style>
        /* BASE LAYOUT INTEGRATION */
        .tracking-viewport { position: relative; display: flex; flex-direction: column; height: 100%; width: 100%; overflow: hidden; }
        .tracking-content { flex: 1; display: flex; position: relative; overflow: hidden; }
        #map { flex: 1; width: 100%; height: 100%; background: #000; }

        /* CONTROL SIDEBAR (RIGHT) */
        #control-sidebar {
            position: relative; width: 100%; height: 50%;
            background: rgba(var(--tw-color-background), 0.95);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1); z-index: 20;
        }
        @media (min-width: 1024px) {
            #control-sidebar { width: 400px; height: 100%; border-top: none; border-left: 1px solid rgba(255, 255, 255, 0.05); }
            #control-sidebar.is-minimized { width: 0px; border-left: none; }
        }
        @media (max-width: 1023px) { #control-sidebar.is-minimized { height: 0px; overflow: hidden; } }

        #sidebar-toggle {
            position: absolute; background: #007bff; color: white; width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 100;
            transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        @media (max-width: 1023px) { #sidebar-toggle { top: -32px; right: 20px; border-radius: 8px 8px 0 0; } }
        @media (min-width: 1024px) { #sidebar-toggle { left: -32px; top: 20px; border-radius: 8px 0 0 8px; } }
        #sidebar-toggle.rotate-180 i { transform: rotate(180deg); }

        /* CYBER SCAN & TACTICAL UI */
        .sidebar-content-wrapper { position: relative; display: flex; flex-direction: column; height: 100%; overflow: hidden; }
        .cyber-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; opacity: 0; z-index: 50; transition: all 0.4s ease; }
        .is-updating .cyber-overlay { opacity: 1; background: linear-gradient(rgba(0, 123, 255, 0.05) 50%, transparent 50%); background-size: 100% 4px; }
        .is-commanding .cyber-overlay { opacity: 1; background: radial-gradient(circle at center, rgba(255, 0, 85, 0.1) 0%, rgba(255, 0, 85, 0.05) 100%); }
        .scan-line { position: absolute; width: 100%; height: 3px; background: #007bff; top: -10px; opacity: 0; z-index: 60; box-shadow: 0 0 15px #007bff; pointer-events: none; }
        @keyframes cyber-scan-move { 0% { top: 0%; opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { top: 100%; opacity: 0; } }
        .is-updating .scan-line { opacity: 1; animation: cyber-scan-move 2s linear infinite; }

        /* MARKER STYLES (RESTORED) */
        .marker-car { position: relative; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .car-icon { font-size: 45px; z-index: 10; filter: drop-shadow(0 0 10px rgba(0,0,0,0.8)); transition: all 0.4s ease; }
        .marker-car.is-active .car-icon { transform: scale(1.3) translateY(-10px); filter: drop-shadow(0 15px 15px rgba(0,123,255,0.6)) hue-rotate(180deg); }

        .pulse-ring { position: absolute; width: 60px; height: 60px; border-radius: 50%; background: rgba(0, 123, 255, 0.4); transform: scale(0); opacity: 0; pointer-events: none; }
        .marker-pulse-active .pulse-ring { animation: dramatic-pulse 2s infinite ease-out; }
        .pulse-danger { position: absolute; width: 60px; height: 60px; border-radius: 50%; background: rgba(255, 0, 85, 0.6); transform: scale(0); opacity: 0; pointer-events: none; }
        .marker-alarm-active .pulse-danger { animation: dramatic-pulse 0.8s infinite ease-out; }
        @keyframes dramatic-pulse { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(6); opacity: 0; } }

        /* TAB STYLES */
        .tactical-tab-container { display: flex; background: rgba(255,255,255,0.03); padding: 4px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.05); margin-top: 15px; }
        .tab-btn { flex: 1; padding: 12px 0; border-radius: 10px; transition: all 0.3s ease; @apply text-[10px] font-black uppercase tracking-widest opacity-40; }
        .tab-btn.is-active { background: #007bff; opacity: 1; color: white; box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); }

        .spinner-custom { display: none; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .is-loading .spinner-custom { display: block; }
    </style>

    <div class="flex grow h-full">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")

        <div class="kt-wrapper flex flex-1 flex-col h-full min-w-0">
            @livewire("metronic.dashboards.layouts.constructors.headers")

            <main class="grow relative flex flex-col overflow-hidden" id="content" role="content">
                <div class="tracking-viewport">
                    <div class="tracking-content">
                        <div id="map"></div>

                        <aside id="control-sidebar" class="flex flex-col shrink-0 shadow-2xl border-white/5">
                            <div id="sidebar-toggle"><i class="ki-filled ki-arrow-right text-sm transition-transform duration-300"></i></div>

                            <div class="sidebar-content-wrapper p-6 h-full">
                                <div class="cyber-overlay"></div>
                                <div class="scan-line"></div>

                                <h2 class="text-2xl font-black italic text-primary uppercase leading-none">Intelligence Hub</h2>
                                <div class="tactical-tab-container">
                                    <button class="tab-btn" data-tab="list">Unit List</button>
                                    <button class="tab-btn" data-tab="detail">Unit Info</button>
                                </div>

                                <div class="grow overflow-hidden mt-6 relative z-[60]">
                                    <div id="tab-list" class="tab-content h-full flex flex-col">
                                        <input type="text" id="unit-search" placeholder="SEARCH ACTIVE NODES..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-[10px] font-black tracking-widest mb-4 focus:outline-none">
                                        <div id="unit-list-container" class="grow overflow-y-auto space-y-3 pr-2"></div>
                                    </div>

                                    <div id="tab-detail" class="tab-content h-full hidden overflow-y-auto space-y-6">
                                        <div id="unit-card" class="rounded-[2rem] relative">
                                            <div class="flex items-center gap-6">
                                                <img id="unit-avatar" src="/storage/media/avatars/blank.png" class="size-20 rounded-3xl object-cover shadow-2xl">
                                                <div>
                                                    <h4 id="unit-name" class="text-xl font-black italic uppercase">System Ready</h4>
                                                    <p id="unit-id" class="text-[10px] font-mono opacity-40 uppercase tracking-widest">Awaiting Link...</p>
                                                </div>
                                            </div>
                                            <div class="mt-8 grid grid-cols-2 gap-4">
                                                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                                                    <span class="text-[9px] font-black opacity-30 uppercase block mb-1">Velocity</span>
                                                    <span id="unit-speed" class="text-xl font-black italic">0.00 <small class="text-[10px] opacity-30">KM/H</small></span>
                                                </div>
                                                <div class="bg-white/5 p-5 rounded-2xl border border-white/5">
                                                    <span class="text-[9px] font-black opacity-30 uppercase block mb-1">Sync Delay</span>
                                                    <span id="unit-time" class="text-xl font-black italic">--:--</span>
                                                </div>
                                            </div>
                                            <button id="btn-ping-driver" class="hidden w-full mt-8 py-5 bg-primary text-white rounded-2xl font-black text-xs uppercase flex items-center justify-center gap-3 active:scale-95 shadow-xl transition-all">
                                                <div class="spinner-custom"></div><span>Execute Loc Update</span>
                                            </button>
                                            <button id="btn-alarm-driver" class="hidden w-full mt-3 py-5 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl font-black text-xs uppercase flex items-center justify-center gap-3 hover:bg-red-500 hover:text-white transition-all">
                                                <div class="spinner-custom"></div><span>Initiate Unit Alarm</span>
                                            </button>
                                        </div>
                                        <div id="log-widget" class="hidden space-y-4">
                                            <h3 class="text-[10px] font-black opacity-30 uppercase tracking-[0.5em]">Live Telemetry</h3>
                                            <div id="log-container" class="space-y-2 max-h-[300px] overflow-hidden"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </main>

            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
    </div>
    <div class="dashboards-apps-trackings"></div>
    </body>
</x-metronic.dashboards.layouts.container>
