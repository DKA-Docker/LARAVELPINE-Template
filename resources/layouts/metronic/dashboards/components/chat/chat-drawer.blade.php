<div class="flex flex-col h-full">
    <div>
        <div class="text-mono flex items-center justify-between gap-2.5 px-5 py-3.5 text-sm font-semibold">
            Chat
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-drawer-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="border-b-border border-b"></div>
        
        {{-- Contact Selector / Selected Contact Header --}}
        <div class="border-border border-b py-2.5">
            @if($selectedReceiverId)
                {{-- Selected Contact Header --}}
                <div class="flex flex-wrap items-center justify-between gap-2 px-5">
                    <div class="flex flex-wrap items-center gap-2">
                        @php
                            $selectedContact = collect($contacts)->firstWhere('id', $selectedReceiverId);
                        @endphp
                        <img alt="" class="size-11 rounded-full" src="{{ $selectedContact['avatar'] ?? '/storage/media/avatars/300-5.png' }}" />
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <span class="text-mono text-sm font-semibold">
                                    {{ $selectedContact['name'] ?? 'User' }}
                                </span>
                                @if($selectedContact['isOnline'] ?? false)
                                    <span class="size-2 rounded-full bg-green-500" title="Online"></span>
                                @endif
                            </div>
                            @if($selectedContact['isOnline'] ?? false)
                                <span class="text-muted-foreground text-xs">Online</span>
                            @elseif($selectedContact['lastSeen'] ?? null)
                                <span class="text-muted-foreground text-xs">{{ $selectedContact['lastSeen'] }}</span>
                            @endif
                            <span class="text-muted-foreground text-xs font-medium italic" id="typing-indicator" style="display: none;"></span>
                        </div>
                    </div>
                    <button wire:click="selectContact(null)" class="kt-btn kt-btn-sm kt-btn-ghost">
                        <i class="ki-filled ki-arrow-left"></i> Back
                    </button>
                </div>
            @else
                {{-- Contact List --}}
                <div class="px-5">
                    <h3 class="text-sm font-semibold mb-3">Select a contact to chat</h3>
                    <div class="flex flex-col gap-2 max-h-[400px] overflow-y-auto">
                        @forelse($contacts as $contact)
                            <button 
                                wire:click="selectContact('{{ $contact['id'] }}')"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-accent/60 transition-colors text-left w-full"
                            >
                                <div class="relative">
                                    <img class="size-10 rounded-full" src="{{ $contact['avatar'] }}" alt="" />
                                    @if($contact['isOnline'] ?? false)
                                        <span class="absolute bottom-0 right-0 size-3 rounded-full bg-green-500 border-2 border-white" title="Online"></span>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium">{{ $contact['name'] }}</span>
                                    @if($contact['isOnline'] ?? false)
                                        <span class="text-xs text-green-600">🟢 Online</span>
                                    @elseif($contact['lastSeen'] ?? null)
                                        <span class="text-xs text-muted-foreground">{{ $contact['lastSeen'] }}</span>
                                    @else
                                        <span class="text-xs text-muted-foreground">Click to chat</span>
                                    @endif
                                </div>
                            </button>
                        @empty
                            <p class="text-sm text-muted-foreground text-center py-4">No contacts available</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
        <div class="border-b-border border-b"></div>
    </div>

    @if($selectedReceiverId)
    {{-- Messages Area (only show when contact is selected) --}}
    <div class="kt-scrollable-y-auto grow" data-kt-scrollable="true" data-kt-scrollable-dependencies="#header" data-kt-scrollable-max-height="auto" data-kt-scrollable-offset="280px" id="chat_messages_container">
        <div class="flex flex-col gap-5 py-5">
            @forelse($messages as $msg)
                @if($msg['user_id'] == auth()->id())
                     {{-- My Message --}}
                    <div class="flex items-end justify-end gap-3.5 px-5">
                        <div class="flex flex-col gap-1.5">
                            <div class="kt-card bg-primary rounded-be-none flex flex-col gap-2.5 p-3 shadow-none">
                                <p class="text-2sm text-primary-foreground font-medium">{{ $msg['body'] }}</p>
                            </div>
                            <div class="relative flex items-center justify-end gap-2">
                                <span class="text-secondary-foreground text-xs font-medium">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                                <i class="ki-filled ki-double-check text-muted-foreground absolute text-lg"></i>
                            </div>
                        </div>
                        <div class="relative shrink-0">
                            <div class="kt-avatar size-9">
                                <div class="kt-avatar-image">
                                    <img alt="avatar" src="{{ asset(Storage::url("media/avatars/300-1.png")) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Incoming Message --}}
                    <div class="flex items-end gap-3.5 px-5">
                        <img alt="" class="size-9 rounded-full" src="{{ $selectedContact['avatar'] ?? '/storage/media/avatars/300-5.png' }}" />
                        <div class="flex flex-col gap-1.5">
                            <div class="kt-card bg-accent/60 rounded-bs-none text-2sm flex flex-col gap-2.5 p-3 shadow-none">{{ $msg['body'] }}</div>
                            <span class="text-muted-foreground text-xs font-medium">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center text-muted-foreground text-sm py-10">
                    No messages yet. Start the conversation!
                </div>
            @endforelse
        </div>
    </div>

    {{-- Input Form --}}
    <div class="mb-2.5 px-5">
        <div class="relative">
            <img alt="" class="absolute start-0 top-2/4 -translate-y-2/4 ms-3.5 size-8 rounded-full" src="{{ asset(Storage::url("media/avatars/300-1.png")) }}" />
            <input 
                id="chat_message_input"
                name="messageBody"
                class="kt-input h-auto bg-transparent text-foreground py-4 ps-12 pe-32" 
                placeholder="Write a message..." 
                type="text" 
                wire:model="messageBody"
                wire:keydown.enter.prevent="sendMessage"
                style="color: inherit !important;"
                autocomplete="off"
            />
            <div class="absolute end-0 top-2/4 -translate-y-2/4 flex items-center gap-2.5 me-3.5">
                <button 
                    type="button" 
                    id="emoji_picker_btn" 
                    class="kt-btn kt-btn-sm kt-btn-icon kt-btn-primary" 
                    title="Add emoji" 
                    style="background: #3b82f6 !important;"
                    onclick="
                        const picker = document.getElementById('emoji_picker_popup');
                        if (picker) {
                            picker.remove();
                            return;
                        }
                        
                        const emojis = ['😀', '😂', '😍', '🥰', '😊', '😎', '🤔', '😢', '😭', '😡', '👍', '👎', '❤️', '🔥', '✨', '🎉', '👏', '🙏', '💯', '✅'];
                        const popup = document.createElement('div');
                        popup.id = 'emoji_picker_popup';
                        popup.className = 'absolute bottom-full right-0 mb-2 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50';
                        popup.style.width = '280px';
                        popup.style.maxHeight = '200px';
                        popup.style.overflowY = 'auto';
                        
                        const grid = document.createElement('div');
                        grid.className = 'grid grid-cols-8 gap-2';
                        
                        emojis.forEach(emoji => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.textContent = emoji;
                            btn.className = 'text-2xl hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-1 transition-colors';
                            btn.onclick = function() {
                                const input = document.getElementById('chat_message_input');
                                const pos = input.selectionStart || 0;
                                const val = input.value;
                                input.value = val.slice(0, pos) + emoji + val.slice(pos);
                                input.focus();
                                input.setSelectionRange(pos + emoji.length, pos + emoji.length);
                                input.dispatchEvent(new Event('input'));
                                popup.remove();
                            };
                            grid.appendChild(btn);
                        });
                        
                        popup.appendChild(grid);
                        this.parentElement.appendChild(popup);
                        
                        setTimeout(() => {
                            document.addEventListener('click', function handler(e) {
                                if (!popup.contains(e.target) && e.target !== document.getElementById('emoji_picker_btn')) {
                                    popup.remove();
                                    document.removeEventListener('click', handler);
                                }
                            });
                        }, 100);
                    "
                >
                    <span style="font-size: 18px;">😀</span>
                </button>
                <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                    <i class="ki-filled ki-exit-up text-lg"></i>
                </button>
                <button type="button" class="kt-btn kt-btn-mono kt-btn-sm" wire:click="sendMessage" wire:loading.attr="disabled">
                    <span wire:loading.remove>Send</span>
                    <span wire:loading>...</span>
                </button>
            </div>
        </div>
    </div>
    @else
    {{-- Show placeholder when no contact selected --}}
    <div class="flex items-center justify-center h-full">
        <div class="text-center">
            <i class="ki-filled ki-message-text text-6xl text-muted-foreground mb-4"></i>
            <p class="text-muted-foreground">Select a contact to start chatting</p>
        </div>
    </div>
    @endif
</div>
