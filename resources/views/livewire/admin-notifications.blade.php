<div class="relative flex items-center justify-center">
    <a href="{{ \App\Filament\Pages\PendingOrders::getUrl() }}" 
       class="relative p-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none transition-colors duration-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 flex items-center justify-center"
       style="width: 36px; height: 36px; display: inline-flex !important; position: relative !important;">
        <span class="sr-only"></span>
        
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
             style="width: 24px !important; height: 24px !important; max-width: 24px !important; max-height: 24px !important; display: block;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"></path>
        </svg>
        
        @if($pendingCount > 0)
            <span class="animate-pulse z-30 flex items-center justify-center shadow-md text-white"
                  style="position: absolute !important; top: 2px !important; right: 2px !important;color: #dc2626 !important;  min-width: 18px; height: 18px; font-size: 11px !important; font-weight: 900 !important; font-family: sans-serif; line-height: 1; padding: 0 4px; transform: translate(15%, -15%);">
                {{ $pendingCount }}
            </span>
        @endif
    </a>

    <audio id="notification-sound" preload="auto">
        <source src="https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3" type="audio/mpeg">
    </audio>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('play-notification-sound', () => {
                const audio = document.getElementById('notification-sound');
                if (audio) {
                    audio.play().catch(e => console.log('Autoplay blocked:', e));
                }
            });
        });
    </script>
</div>