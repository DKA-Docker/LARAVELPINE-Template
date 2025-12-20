<div class="relative overflow-hidden rounded-[2.5rem] min-h-[580px] flex items-center justify-center p-6 animate-page-entry">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96  rounded-full blur-[100px] animate-pulse" style="animation-duration: 4s"></div>
    </div>

    <div class="relative z-10 w-full max-w-lg">
        {{-- Glassmorphism Card --}}
        <div class="backdrop-blur-3xl shadow-[0_32px_64px_-15px_rgba(0,0,0,0.05)] rounded-[3.5rem] p-10 md:p-14 text-center">

            {{-- Illustration Header --}}
            <div class="relative inline-flex mb-10">
                <div class="absolute inset-0 bg-danger/20 blur-3xl rounded-full scale-150 animate-soft-glow"></div>

                {{-- SVG Flat Illustration --}}
                <svg width="180" height="180" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="relative animate-float">
                    {{-- Shield Base --}}
                    <path d="M100 30C100 30 60 40 60 85C60 130 100 165 100 165C100 165 140 130 140 85C140 40 100 30 100 30Z" fill="#FEE2E2"/>
                    <path d="M100 45C100 45 72 52 72 85C72 118 100 145 100 145C100 145 128 118 128 85C128 52 100 45 100 45Z" fill="#EF4444"/>

                    {{-- Lock Icon on Shield --}}
                    <rect x="85" y="85" width="30" height="22" rx="3" fill="white" class="animate-lock-shimmer"/>
                    <path d="M90 85V78C90 72.4772 94.4772 68 100 68C105.523 68 110 72.4772 110 78V85" stroke="white" stroke-width="4" stroke-linecap="round"/>

                    {{-- Floating Code Elements --}}
                    <g class="animate-float-slow">
                        <rect x="150" y="50" width="25" height="25" rx="6" fill="#1F2937" class="animate-rotate-slow"/>
                        <path d="M157 58L155 62.5L157 67M168 58L170 62.5L168 67" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>

                    <circle cx="45" cy="140" r="8" fill="#F87171" class="animate-pulse"/>
                </svg>
            </div>

            {{-- Text Content --}}
            <div class="space-y-4 mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full mb-2">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-danger opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-danger"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">Security Protocol Active</span>
                </div>

                <h1 class="text-4xl font-bolder tracking-tight leading-tight">
                    Akses <span class="text-danger">Terbatas</span>
                </h1>
                <p class="text-gray-500 text-lg font-medium leading-relaxed">
                    Maaf, akun Anda tidak memiliki izin yang cukup untuk melihat data ini.
                </p>
            </div>

            {{-- Modern Action Button --}}
            <div class="flex flex-col items-center gap-6">
                <button
                    onclick="window.history.back()"
                    class="group relative flex items-center justify-center gap-3 w-full sm:w-auto px-10 py-4 bg-gray-900 text-white font-bold rounded-2xl transition-all duration-300 hover:bg-black hover:-translate-y-1 hover:shadow-[0_20px_40px_-10px_rgba(0,0,0,0.3)] active:scale-95"
                >
                    <i class="ki-filled ki-arrow-left text-xl transition-transform group-hover:-translate-x-1"></i>
                    Kembali Sekarang
                </button>

                <p class="text-sm font-semibold text-gray-400">
                    Butuh bantuan? <a href="#" class="text-primary hover:underline transition-all">Hubungi IT Support</a>
                </p>
            </div>
        </div>
    </div>

    {{-- Styling & Animations --}}
    <style>
        @keyframes page-entry {
            from { opacity: 0; transform: scale(0.97) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        @keyframes float-slow {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-10px, -20px); }
        }
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes soft-glow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.2); }
        }
        @keyframes lock-shimmer {
            0%, 100% { fill: white; }
            50% { fill: #FEE2E2; }
        }

        .animate-page-entry { animation: page-entry 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-float { animation: float 5s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 7s ease-in-out infinite; }
        .animate-rotate-slow { animation: rotate-slow 12s linear infinite; transform-origin: center; }
        .animate-soft-glow { animation: soft-glow 4s ease-in-out infinite; }
        .animate-lock-shimmer { animation: lock-shimmer 2s ease-in-out infinite; }
    </style>
</div>
