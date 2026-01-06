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
        .tracking-content { flex: 1; display: flex; position: relative; overflow: hidden; height: 100%; }
        #map { flex: 1; width: 100%; height: 100%; background: #000; }

        /* CONTROL SIDEBAR (RIGHT) */
        /* CONTROL SIDEBAR (RIGHT) */
        /* Styles moved to IntelHub Component / managed by Tailwind classes */

        /* CONTROL SIDEBAR (RIGHT) */
        /* Styles moved to IntelHub Component / managed by Tailwind classes */

        /* CYBER SCAN & TACTICAL UI */

        /* CYBER SCAN & TACTICAL UI */
        .sidebar-content-wrapper { position: relative; display: flex; flex-direction: column; height: 100%; overflow: hidden; z-index: 0; }
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

        /* GLASS SIDEBAR */
        /* GLASS SIDEBAR */
        /* GLASS SIDEBAR */
        .glass-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-left: 1px solid rgba(0, 0, 0, 0.05); }
        .dark .glass-panel { background: rgba(5, 5, 10, 0.9); border-left: 1px solid rgba(255, 255, 255, 0.08); }
        .is-minimized .glass-panel { border-left: none; }

        /* HUD ELEMENTS */
        .scan-line-overlay { background: linear-gradient(to bottom, transparent, rgba(59, 130, 246, 0.1), transparent); background-size: 100% 8px; animation: scan-vertical 3s linear infinite; }
        @keyframes scan-vertical { 0% { transform: translateY(-100%); } 100% { transform: translateY(100%); } }

        /* CUSTOM SCROLLBAR FOR HUB */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(59, 130, 246, 0.3); border-radius: 2px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(59, 130, 246, 0.6); }

        .spinner-custom { display: none; width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .is-loading .spinner-custom { display: block; }
    </style>

    <div class="flex grow h-full">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")

        <div class="kt-wrapper flex flex-1 flex-col h-full min-w-0">
            @livewire("metronic.dashboards.layouts.constructors.headers")

            <main class="grow relative flex flex-col overflow-hidden bg-white dark:bg-black transition-colors duration-300 isolate" id="content" role="content">
                <div class="tracking-viewport relative z-0">
                    {{-- JARVIS HUD OVERLAY --}}
                    <div class="hud-layer pointer-events-none absolute inset-0 z-0 overflow-hidden">
                        {{-- GRID BACKGROUND --}}
                        <div class="absolute inset-0 bg-[linear-gradient(rgba(59,130,246,0.1)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.1)_1px,transparent_1px)] dark:bg-[linear-gradient(rgba(0,123,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(0,123,255,0.03)_1px,transparent_1px)] bg-[size:40px_40px] [mask-image:radial-gradient(circle_at_center,black_60%,transparent_100%)]"></div>

                        {{-- CORNER BRACKETS --}}
                        <div class="absolute top-4 left-4 w-16 h-16 border-l-2 border-t-2 border-blue-500/50 rounded-tl-lg"></div>
                        <div class="absolute top-4 right-4 w-16 h-16 border-r-2 border-t-2 border-blue-500/50 rounded-tr-lg"></div>
                        <div class="absolute bottom-4 left-4 w-16 h-16 border-l-2 border-b-2 border-blue-500/50 rounded-bl-lg"></div>
                        <div class="absolute bottom-4 right-4 w-16 h-16 border-r-2 border-b-2 border-blue-500/50 rounded-br-lg"></div>

                        {{-- SYSTEM STATUS --}}
                        <div class="absolute top-6 left-8 flex items-center gap-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black tracking-[0.2em] text-blue-400/80 uppercase">{{ __('dashboard.tracking.hud.system_status') }}</span>
                                <span class="text-xl font-black text-blue-500 tracking-widest leading-none drop-shadow-[0_0_10px_rgba(59,130,246,0.5)]">{{ __('dashboard.tracking.hud.online') }}</span>
                            </div>
                            <div class="h-8 w-[1px] bg-blue-500/30"></div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black tracking-[0.2em] text-blue-400/80 uppercase">{{ __('dashboard.tracking.hud.active_units') }}</span>
                                <span id="hud-active-count" class="text-xl font-black text-emerald-400 tracking-widest leading-none">00</span>
                            </div>
                        </div>

                        {{-- TIME --}}
                        <div class="absolute top-6 right-8 text-right">
                             <span id="hud-time" class="text-2xl font-mono font-bold text-blue-500/80 tracking-widest">00:00:00</span>
                             <div class="text-[9px] font-black text-blue-400/50 uppercase tracking-[0.3em] mt-1">{{ __('dashboard.tracking.hud.time_sync') }}</div>
                        </div>

                        {{-- SCAN LINES ANIMATION --}}
                        <div class="scan-line-overlay absolute inset-0 opacity-10 pointer-events-none"></div>
                    </div>

                    <div class="tracking-content">
                        <div id="map"></div>

                        {{-- INTEL HUB COMPONENT (Lazy Loaded) --}}
                        {{-- INTEL HUB COMPONENT (Lazy Loaded) --}}
                        @livewire('metronic.dashboards.apps.trackings.components.intel-hub')
                    </div>
                </div>
            </main>

            @livewire("metronic.dashboards.layouts.constructors.footers")
        </div>
    </div>
    <div class="dashboards-apps-trackings"></div>
    </body>
</x-metronic.dashboards.layouts.container>
