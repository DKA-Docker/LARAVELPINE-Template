<footer class="kt-footer mt-auto border-t border-gray-200 dark:border-white/5 bg-background/95 backdrop-blur-md relative z-[100] flex-shrink-0">
    <div class="kt-container-fixed container-fluid">
        <div class="flex flex-col items-center justify-center gap-3 py-5 md:flex-row md:justify-between">
            <div class="order-2 flex items-center gap-1.5 text-sm font-normal md:order-1">
                <span class="text-gray-500">2026©</span>
                <a class="text-gray-700 dark:text-gray-400 hover:text-primary transition-colors font-medium uppercase tracking-wider text-[11px]" href="https://hndgroup.id" target="_blank">
                    HNDGroup Dev Team.
                </a>
            </div>

            <nav class="order-1 flex items-center gap-4 text-sm font-normal md:order-2">
                <a class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors text-2sm" href="#">Docs</a>
                <a class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors text-2sm" href="#">API</a>
                <a class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors text-2sm" href="#">FAQ</a>
                <a class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors text-2sm" href="#">Support</a>
                <a class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors text-2sm" href="#">About</a>
            </nav>
        </div>
    </div>

    {{-- Style dimasukkan ke dalam root element agar Livewire tetap menganggapnya satu kesatuan --}}
    <style>
        .dark .kt-footer {
            background-color: #0f1014; /* Menyesuaikan background dark demo1 */
        }

        /* Memastikan area konten utama tidak menutupi footer */
        .kt-footer {
            width: 100%;
            position: relative;
        }
    </style>
</footer>
