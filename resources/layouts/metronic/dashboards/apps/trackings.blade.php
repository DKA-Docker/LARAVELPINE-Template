<x-metronic.dashboards.layouts.container>
    <body class="text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed flex h-screen text-base antialiased overflow-hidden">

    <style>
        /* --- ANIMASI JARVIS --- */
        @keyframes scan-line {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100vh); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(1.2); opacity: 0; }
        }
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .animate-scan { animation: scan-line 8s linear infinite; }
        .animate-rotate { animation: rotate-slow 15s linear infinite; }
        .animate-slide-right { animation: slideInRight 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }

        /* --- UI JARVIS ELEMENTS --- */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-left: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass-panel {
            background: rgba(24, 24, 27, 0.8);
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }
        .modern-card {
            background: rgba(0, 123, 255, 0.03);
            border: 1px solid rgba(0, 123, 255, 0.1);
        }

        /* --- LAYOUT FIX --- */
        .main-tracking-area {
            position: absolute;
            top: 60px;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            overflow: hidden;
            z-index: 1;
        }
        @media (min-width: 1024px) {
            .main-tracking-area { top: 70px; }
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
    </style>

    <div class="flex grow h-full">
        @livewire("metronic.dashboards.layouts.constructors.sidebars")

        <div class="kt-wrapper flex flex-1 flex-col h-full min-w-0 relative">
            @livewire("metronic.dashboards.layouts.constructors.headers")

            <div class="main-tracking-area">

                <div class="relative flex-1 h-full min-w-0 bg-black overflow-hidden group">

                    <div id="map" class="w-full h-full z-0 grayscale-[0.3] contrast-[1.1]"></div>
                </div>

                <aside class="glass-sidebar w-80 lg:w-[400px] h-full flex flex-col shadow-2xl animate-slide-right shrink-0 z-20">

                    <div class="p-6 border-b border-white/10 dark:border-white/5">
                        <div class="flex justify-between items-end">
                            <div>
                                <h2 class="text-xl font-black tracking-tighter uppercase italic">Control Hub</h2>
                                <p class="text-[10px] opacity-50 font-bold tracking-[0.2em] uppercase">Logistics Intelligence</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-mono font-bold text-primary">v2.4.0</span>
                            </div>
                        </div>
                    </div>

                    <div class="grow overflow-y-auto p-6 space-y-8 custom-scrollbar">

                        <div class="space-y-4">
                            <h3 class="text-[10px] font-black opacity-40 uppercase tracking-[0.3em]">Selected Unit</h3>
                            <div class="glass-card p-5 rounded-[2rem] relative overflow-hidden group hover:border-primary/50 transition-all duration-500">
                                <div class="flex items-center gap-5 relative z-10">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-primary/20 blur-xl rounded-full"></div>
                                        <img src="{{ asset(Storage::url('media/avatars/300-1.png')) }}" class="size-14 rounded-full object-cover border-2 border-white/50 relative">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-base font-bold tracking-tight">Rahmat Hidayat</h4>
                                        <p class="text-[10px] font-mono opacity-60">ID: DRV-99021 / WINGS-BOX</p>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-2 gap-3 relative z-10">
                                    <div class="bg-white/10 dark:bg-black/20 p-3 rounded-2xl border border-white/10">
                                        <span class="block text-[9px] uppercase font-bold opacity-50 mb-1">Fuel Level</span>
                                        <span class="text-sm font-black italic">82.4%</span>
                                    </div>
                                    <div class="bg-white/10 dark:bg-black/20 p-3 rounded-2xl border border-white/10">
                                        <span class="block text-[9px] uppercase font-bold opacity-50 mb-1">Cargo Temp</span>
                                        <span class="text-sm font-black italic text-blue-500">4.2°C</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-[10px] font-black opacity-40 uppercase tracking-[0.3em]">Fleet Performance</h3>
                            <div class="space-y-3">
                                <div class="glass-card flex justify-between items-center p-4 rounded-2xl hover:bg-white/30 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                                            <i class="ki-filled ki-geolocation text-lg"></i>
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-tighter">Total Distance</span>
                                    </div>
                                    <span class="text-sm font-black font-mono">1,240.8 <span class="text-[10px]">KM</span></span>
                                </div>

                                <div class="glass-card flex justify-between items-center p-4 rounded-2xl hover:bg-white/30 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="size-10 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 shadow-inner">
                                            <i class="ki-filled ki-delivery-door text-lg"></i>
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-tighter">Completed</span>
                                    </div>
                                    <span class="text-sm font-black font-mono">32 <span class="text-[10px]">TASKS</span></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-orange-500/10 border border-orange-500/20 p-5 rounded-[2rem] backdrop-blur-md">
                            <div class="flex gap-4">
                                <i class="ki-filled ki-shield-search text-orange-500 text-xl"></i>
                                <div>
                                    <h5 class="text-xs font-black uppercase text-orange-700 dark:text-orange-400">Security Alert</h5>
                                    <p class="text-[10px] leading-relaxed mt-1 opacity-80 font-medium">Unit B 9921 KAA terdeteksi keluar dari jalur utama (Geo-fencing breach).</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div class="flex justify-between items-end">
                                <span class="text-[10px] font-black opacity-40 uppercase tracking-[0.3em]">Shipment Trip</span>
                                <span class="text-xs font-black text-primary italic">75%</span>
                            </div>
                            <div class="h-3 w-full bg-black/5 dark:bg-white/5 rounded-full p-[3px]">
                                <div class="h-full bg-gradient-to-r from-primary to-blue-400 rounded-full shadow-[0_0_15px_rgba(0,123,255,0.4)] transition-all duration-1000" style="width: 75%"></div>
                            </div>
                            <div class="flex justify-between text-[9px] font-bold opacity-60 uppercase italic">
                                <span>Origin: JKT</span>
                                <span>Dest: BDG</span>
                            </div>
                        </div>

                    </div>

                    <div class="p-6 dark:bg-black/10 backdrop-blur-md border-t border-white/10">
                        <button class="w-full py-4 bg-primary text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-primary-active transition-all shadow-xl shadow-primary/20 active:scale-[0.98]">
                            View Detailed Intelligence
                        </button>
                    </div>
                </aside>

            </div> </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const resizeObserver = new ResizeObserver(() => {
                window.dispatchEvent(new Event('resize'));
            });
            const mapContainer = document.getElementById('map');
            if(mapContainer) resizeObserver.observe(mapContainer);
        });
    </script>

    <div class="dashboards-apps-trackings"></div>

    </body>
</x-metronic.dashboards.layouts.container>
