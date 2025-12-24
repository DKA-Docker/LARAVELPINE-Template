<div class="flex flex-col items-center grow bg-center bg-no-repeat page-bg min-h-screen pt-32 pb-10">
    <div class="container max-w-6xl mx-auto px-4">
        <!-- Header Section -->
        <div class="glass-card rounded-2xl p-10 mb-8 animate-fade-up shadow-xl border-t-4 border-primary/80">
            <div class="flex items-center justify-between flex-wrap gap-6">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-blue-600 text-white shadow-lg shadow-primary/30">
                            <i class="ki-filled ki-shield-tick text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-mono text-4xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">
                                Privacy Policy
                            </h1>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">Logistech Driver Application</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 ml-18">
                        <i class="ki-filled ki-calendar text-primary"></i>
                        <span class="font-mono bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded text-xs">Effective: {{ date('F d, Y') }}</span>
                    </div>
                </div>
                <a href="{{ route('auth.index') }}" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all font-medium text-gray-700 dark:text-gray-200" wire:navigate>
                    <i class="ki-filled ki-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Back to Login</span>
                </a>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="flex flex-col gap-8">
            @foreach($sections as $index => $section)
                <div class="glass-card rounded-2xl overflow-hidden section-card animate-fade-up shadow-md hover:shadow-xl transition-all duration-300" style="animation-delay: {{ ($index + 1) * 0.1 }}s">
                    <!-- Section Header -->
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-white/5 flex items-center gap-4">
                            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 text-primary font-bold text-lg">
                            {{ $index + 1 }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                            {{ $section['title'] }}
                        </h2>
                    </div>
                    
                    <!-- Bilingual Content Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100 dark:divide-gray-700/50">
                        <!-- English Column -->
                        <div class="p-6 md:p-8 bg-white/40 dark:bg-transparent">
                            <div class="flex items-center gap-2 mb-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">English</span>
                            </div>
                            <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                                {!! $section['content_en'] !!}
                            </div>
                        </div>

                        <!-- Indonesian Column -->
                        <div class="p-6 md:p-8 bg-gray-50/40 dark:bg-gray-800/20">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Bahasa Indonesia</span>
                            </div>
                            <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                                    {!! $section['content_id'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Footer Section -->
        <div class="glass-card rounded-2xl p-8 mt-8 animate-fade-up shadow-lg border-t border-gray-100 dark:border-gray-700" style="animation-delay: {{ (count($sections) + 1) * 0.1 }}s">
            <div class="text-center">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Legal Disclaimer</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-2xl mx-auto mb-6">
                    This Privacy Policy is effective as of {{ date('Y') }} and governs the use of the Logistech Driver App. Use of the App constitutes acceptance of these terms.
                </p>
                <a href="{{ route('auth.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl bg-primary text-white font-semibold hover:bg-primary-active shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all active:scale-95" wire:navigate>
                    <span>Acknowledge & Continue</span>
                    <i class="ki-filled ki-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; 
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
    }
    .dark .glass-card {
        background: rgba(17, 24, 39, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
    }
    .section-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .section-card:hover {
        transform: translateY(-4px) scale(1.01);
        background: rgba(255, 255, 255, 0.95);
        border-color: var(--bs-primary);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    .dark .section-card:hover {
        background: rgba(31, 41, 55, 0.9);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }
</style>
