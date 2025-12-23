<aside id="control-sidebar" x-data x-init="$dispatch('intel-hub-ready')" class="group/sidebar flex flex-col shrink-0 shadow-2xl border-l border-blue-200/50 dark:border-white/10 glass-panel transition-all z-[1] w-full lg:w-[400px] self-stretch min-h-full [&.is-minimized]:!w-0 [&.is-minimized]:!border-0 relative" style="z-index: 1;">
    <div id="sidebar-toggle" style="top: 50% !important; transform: translateY(-50%) !important;" class="absolute bg-white -left-8 w-8 h-32 rounded-l-xl flex items-center justify-center cursor-pointer z-[60] text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 transition-all group"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 transition-transform duration-300 group-hover:scale-110"><path d="M15 18l-6-6 6-6"/></svg></div>

    <div class="sidebar-content-wrapper p-6 h-full relative z-[2] group-[.is-minimized]/sidebar:opacity-0 group-[.is-minimized]/sidebar:invisible transition-all duration-300">
        {{-- DECORATIVE SIDEBAR ELEMENTS --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500/50 to-transparent opacity-80 dark:opacity-100"></div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500/20 to-transparent opacity-80 dark:opacity-100"></div>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse shadow-[0_0_10px_#3b82f6]"></div>
            <h2 class="text-2xl font-black italic text-gray-800 dark:text-white uppercase leading-none tracking-tighter drop-shadow-md">
                <span class="text-blue-600 dark:text-blue-500">INTEL</span> HUB
            </h2>
        </div>

        <div class="tactical-tab-container backdrop-blur-md">
            <button class="tab-btn is-active" data-tab="list">Unit List</button>
            <button class="tab-btn" data-tab="detail">Unit Info</button>
        </div>

        <div class="grow overflow-hidden mt-6 relative z-[60]">
            <div id="tab-list" class="tab-content h-full flex flex-col">
                <div class="relative group">
                    <input type="text" id="unit-search" placeholder="SEARCH ACTIVE NODES..." class="w-full border border-blue-200 dark:border-blue-500/20 rounded-xl px-4 py-4 pr-10 text-[10px] font-black tracking-widest mb-4 focus:outline-none focus:border-blue-500 focus:bg-white dark:focus:bg-blue-500/5 transition-all text-gray-900 dark:text-blue-100 placeholder-blue-600/50 dark:placeholder-blue-500/30 shadow-sm dark:shadow-none">
                    <i class="ki-filled ki-magnifier absolute right-4 top-1/2 -translate-y-[calc(50%+8px)] text-blue-600/70 dark:text-blue-500/50 transform"></i>
                </div>
                {{-- wire:ignore: jQuery manages this list --}}
                <div id="unit-list-container" wire:ignore class="grow overflow-y-auto space-y-2 pr-2 custom-scrollbar"></div>
            </div>

            {{-- wire:ignore: jQuery manages details/animations --}}
            <div id="tab-detail" wire:ignore class="tab-content h-full hidden overflow-y-auto space-y-6 custom-scrollbar">
                <div id="unit-card" class="rounded-[2rem] relative dark:bg-gradient-to-b dark:from-white/5 dark:to-transparent border border-gray-200 dark:border-white/5 p-4 shadow-sm dark:shadow-none">
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <img id="unit-avatar" src="/storage/media/avatars/blank.png" class="size-20 rounded-2xl object-cover shadow-2xl ring-2 ring-white/10">
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full ring-2 ring-black"></div>
                        </div>
                        <div class="overflow-hidden">
                            <h4 id="unit-name" class="text-lg font-black italic uppercase text-gray-800 dark:text-white truncate typing-target">System Ready</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                <p id="unit-id" class="text-[9px] font-mono text-gray-500 dark:text-blue-400 uppercase tracking-widest typing-target">Awaiting Link...</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="p-4 rounded-xl border border-gray-200 dark:border-white/5 group hover:border-blue-500/30 transition-colors">
                            <span class="text-[8px] font-black text-gray-400 dark:text-blue-400/50 uppercase block mb-1 tracking-wider">Velocity</span>
                            <span id="unit-speed" class="text-xl font-black italic text-gray-800 dark:text-white typing-target">0.00 <small class="text-[9px] text-gray-400 dark:text-white/30">KM/H</small></span>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-200 dark:border-white/5 group hover:border-blue-500/30 transition-colors">
                            <span class="text-[8px] font-black text-gray-400 dark:text-blue-400/50 uppercase block mb-1 tracking-wider">Sync Delay</span>
                            <span id="unit-time" class="text-xl font-black italic text-gray-800 dark:text-white typing-target">--:--</span>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                            <button id="btn-ping-driver" class="hidden w-full py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-black text-[10px] uppercase flex items-center justify-center gap-3 active:scale-[0.98] shadow-lg shadow-blue-900/20 transition-all group">
                            <div class="spinner-custom"></div>
                            <span class="group-hover:tracking-widest transition-all">Execute Loc Update</span>
                        </button>
                        <button id="btn-alarm-driver" class="hidden w-full py-4 bg-red-500/10 border border-red-500/30 text-red-500 hover:bg-red-500 hover:text-white rounded-xl font-black text-[10px] uppercase flex items-center justify-center gap-3 transition-all group">
                            <div class="spinner-custom"></div>
                            <span class="group-hover:tracking-widest transition-all">Initiate Unit Alarm</span>
                        </button>
                    </div>
                </div>
                <div id="log-widget" class="hidden space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-[9px] font-black text-blue-400/50 uppercase tracking-[0.2em]">Live Telemetry</h3>
                        <div class="flex gap-1">
                            <div class="w-1 h-3 bg-blue-500/30"></div>
                            <div class="w-1 h-3 bg-blue-500/30"></div>
                            <div class="w-1 h-3 bg-blue-500/30"></div>
                        </div>
                    </div>
                    <div id="log-container" class="space-y-1.5 max-h-[250px] overflow-hidden font-mono text-[10px]"></div>
                </div>
            </div>
        </div>
    </div>
</aside>
