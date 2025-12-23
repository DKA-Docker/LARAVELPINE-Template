import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import $ from 'jquery';
import moment from 'moment';

declare global {
    interface Window {
        Pusher: typeof Pusher;
        Echo: Echo<"reverb">;
        jQuery: typeof $;
        $: typeof $;
    }
}

const getCfg = (name: string): string => {
    const meta = document.querySelector(`meta[name="${name}"]`) as HTMLMetaElement;
    return meta ? meta.content : '';
};

// Get current user ID from meta tag or data attribute
const getCurrentUserId = (): string => {
    const meta = document.querySelector('meta[name="user-id"]') as HTMLMetaElement;
    return meta ? meta.content : '';
};

// Initialize Echo if not already initialized
if (!window.Echo) {
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: getCfg('reverb-key'),
        wsHost: getCfg('reverb-host'),
        wsPort: parseInt(getCfg('reverb-port')) || 80,
        wssPort: parseInt(getCfg('reverb-port')) || 443,
        forceTLS: getCfg('reverb-scheme') === 'https',
        enabledTransports: ['ws', 'wss'],
    });

    console.log('[Chat] Reverb Echo initialized');
}

// Auto-scroll chat to bottom when new messages arrive
const scrollChatToBottom = () => {
    const container = document.getElementById('chat_messages_container');
    if (container) {
        // Use requestAnimationFrame for smoother scrolling
        requestAnimationFrame(() => {
            container.scrollTop = container.scrollHeight;

            // Also try scrollIntoView on last message as fallback
            const lastMessage = container.querySelector('div > div:last-child');
            if (lastMessage) {
                lastMessage.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }
        });
    }
};

// Listen for Livewire updates and scroll
document.addEventListener('livewire:initialized', () => {
    scrollChatToBottom();
});

// Also scroll on any DOM mutation in chat container
const observer = new MutationObserver(() => {
    scrollChatToBottom();
});

const chatContainer = document.getElementById('chat_messages_container');
if (chatContainer) {
    observer.observe(chatContainer, { childList: true, subtree: true });
}

// Firefox fix: Complete manual input handling
document.addEventListener('livewire:initialized', () => {
    const chatInput = document.getElementById('chat_message_input') as HTMLInputElement;
    if (!chatInput) return;

    const isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;

    if (isFirefox) {
        console.log('[Chat] Firefox detected, applying complete input workaround');

        // Find Livewire component
        const findLivewireComponent = () => {
            const chatDrawerElement = document.querySelector('[wire\\:id]');
            return chatDrawerElement ? (window as any).Livewire?.find(chatDrawerElement.getAttribute('wire:id')) : null;
        };

        // Manual input sync
        chatInput.addEventListener('input', function (this: HTMLInputElement) {
            const component = findLivewireComponent();
            if (component) {
                component.set('messageBody', this.value);
            }
        });

        // Manual Enter key
        chatInput.addEventListener('keydown', function (this: HTMLInputElement, e: KeyboardEvent) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                e.stopPropagation();

                const component = findLivewireComponent();
                if (component && this.value.trim()) {
                    component.call('sendMessage').then(() => {
                        this.value = '';
                        component.set('messageBody', '');
                    });
                }
            }
        });

        console.log('[Chat] Firefox workaround applied successfully');
    }
});

// Helper function to select contact and show message
const selectContactAndShowMessage = (contactId: string, message: any, currentUserId: string) => {
    console.log('[Chat] Auto-selecting contact:', contactId);

    // Find contact button and click it programmatically
    const contactButtons = document.querySelectorAll('[wire\\:click*="selectContact"]');
    let contactButton: HTMLElement | null = null;

    contactButtons.forEach((button) => {
        const wireClick = button.getAttribute('wire:click');
        if (wireClick && wireClick.includes(contactId)) {
            contactButton = button as HTMLElement;
        }
    });

    if (contactButton) {
        console.log('[Chat] Clicking contact button to select contact');
        contactButton.click();

        // Update global variable
        globalSelectedReceiverId = contactId;

        // Wait for Livewire to load messages, then append new message
        setTimeout(() => {
            appendMessageToDOM(message, currentUserId);
        }, 500);
    } else {
        console.error('[Chat] Contact button not found for ID:', contactId);
        // Fallback: just update global variable and show message
        globalSelectedReceiverId = contactId;
        appendMessageToDOM(message, currentUserId);
    }
};

// Typing Indicator Logic
let typingTimeout: NodeJS.Timeout | null = null;

// Track selected receiver ID globally
let globalSelectedReceiverId: string | null = null;

// Listen for Livewire contact-selected event
document.addEventListener('livewire:init', () => {
    (window as any).Livewire.on('contact-selected', (event: any) => {
        globalSelectedReceiverId = event.receiverId;
        console.log('[Chat] Contact selected, receiverId:', globalSelectedReceiverId);
    });
});

console.log('[Chat] Setting up Echo listeners on channel: chat');

window.Echo.channel('chat')
    .listen('.UserTyping', (event: any) => {
        console.log('[Chat] UserTyping event received:', event);
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator && event.user) {
            typingIndicator.textContent = `${event.user.name} is typing...`;
            typingIndicator.style.display = 'block';

            // Clear previous timeout
            if (typingTimeout) clearTimeout(typingTimeout);

            // Hide after 3 seconds of no typing
            typingTimeout = setTimeout(() => {
                typingIndicator.style.display = 'none';
            }, 3000);
        }
    })
    .listen('.MessageSent', (event: any) => {
        console.log('[Chat] ========================================');
        console.log('[Chat] MessageSent event received!', event);
        console.log('[Chat] Message data:', event.message);
        console.log('[Chat] ========================================');
        const message = event.message;
        const currentUserId = getCurrentUserId();

        // Use global selectedReceiverId that's updated via Livewire event
        const selectedReceiverId = globalSelectedReceiverId;

        // Check if message is for current user
        const isIncomingMessage = message.receiver_id === currentUserId;
        const isMyMessage = message.user_id === currentUserId;

        if (isIncomingMessage && !isMyMessage) {
            // Message is for me from someone else
            console.log('[Chat] Incoming message from', message.user_id);

            // Open chat drawer if not already open
            const chatDrawer = document.getElementById('chat_drawer');
            const isDrawerOpen = chatDrawer && chatDrawer.classList.contains('open');

            if (chatDrawer && !isDrawerOpen) {
                const drawerToggle = document.querySelector('[data-kt-drawer-toggle="#chat_drawer"]');
                if (drawerToggle) {
                    (drawerToggle as HTMLElement).click();
                    console.log('[Chat] Opening chat drawer');

                    // Wait for drawer to open and Livewire to initialize, then select contact
                    setTimeout(() => {
                        selectContactAndShowMessage(message.user_id, message, currentUserId);
                    }, 500);
                    return; // Exit early, message will be shown after contact selection
                }
            } else if (isDrawerOpen) {
                // Drawer already open, just select contact if needed
                if (globalSelectedReceiverId !== message.user_id) {
                    selectContactAndShowMessage(message.user_id, message, currentUserId);
                    return;
                }
            }
        }

        // For messages in current conversation, append immediately
        const messagesContainer = document.querySelector('#chat_messages_container > div');
        if (!messagesContainer) {
            console.log('[Chat] Messages container not found');
            return;
        }

        // Debug: Log all IDs for comparison
        console.log('[Chat] Comparing IDs:', {
            'message.user_id': message.user_id,
            'message.receiver_id': message.receiver_id,
            'currentUserId': currentUserId,
            'selectedReceiverId': selectedReceiverId
        });

        // If no contact selected, skip (user needs to select contact first)
        if (!selectedReceiverId || selectedReceiverId === 'null' || selectedReceiverId === 'undefined') {
            console.log('[Chat] No contact selected, message will appear when user selects contact');
            return;
        }

        // Only show message if it's part of current conversation
        // Convert to string for comparison to avoid type mismatch
        const isForMe = String(message.receiver_id) === String(currentUserId) && String(message.user_id) === String(selectedReceiverId);
        const isFromMe = String(message.user_id) === String(currentUserId) && String(message.receiver_id) === String(selectedReceiverId);

        console.log('[Chat] Message match check:', { isForMe, isFromMe });

        if (!isForMe && !isFromMe) {
            console.log('[Chat] Message not for current conversation, ignoring');
            return;
        }

        console.log('[Chat] ✅ Received message for current conversation, appending to DOM');
        appendMessageToDOM(message, currentUserId);
    });

// Helper function to append message to DOM
function appendMessageToDOM(message: any, currentUserId: string) {
    const messagesContainer = document.querySelector('#chat_messages_container > div');
    if (!messagesContainer) {
        console.log('[Chat] Messages container not found, skipping append');
        return;
    }

    // Remove "No messages" placeholder if exists
    const noMessages = messagesContainer.querySelector('.text-center.text-muted-foreground');
    if (noMessages) noMessages.remove();

    const isMyMessage = message.user_id === currentUserId;
    const time = moment(message.created_at).format('HH:mm');

    let messageHtml = '';

    if (isMyMessage) {
        // My message (right side)
        messageHtml = `
            <div class="flex items-end justify-end gap-3.5 px-5">
                <div class="flex flex-col gap-1.5">
                    <div class="kt-card bg-primary rounded-be-none flex flex-col gap-2.5 p-3 shadow-none">
                        <p class="text-2sm text-primary-foreground font-medium">${message.body}</p>
                    </div>
                    <div class="relative flex items-center justify-end gap-2">
                        <span class="text-secondary-foreground text-xs font-medium">${time}</span>
                        <i class="ki-filled ki-double-check text-muted-foreground absolute text-lg"></i>
                    </div>
                </div>
                <div class="relative shrink-0">
                    <div class="kt-avatar size-9">
                        <div class="kt-avatar-image">
                            <img alt="avatar" src="/storage/media/avatars/300-1.png" />
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        // Incoming message (left side)
        messageHtml = `
            <div class="flex items-end gap-3.5 px-5">
                <img alt="" class="size-9 rounded-full" src="/storage/media/avatars/300-5.png" />
                <div class="flex flex-col gap-1.5">
                    <div class="kt-card bg-accent/60 rounded-bs-none text-2sm flex flex-col gap-2.5 p-3 shadow-none">${message.body}</div>
                    <span class="text-muted-foreground text-xs font-medium">${time}</span>
                </div>
            </div>
        `;
    }

    messagesContainer.insertAdjacentHTML('beforeend', messageHtml);

    // Wait for DOM to update, then scroll
    setTimeout(() => {
        scrollChatToBottom();
    }, 50);

    console.log('[Chat] Message appended to DOM');
}


// Emoji Picker functionality
document.addEventListener('livewire:initialized', () => {
    const emojiBtn = document.getElementById('emoji_picker_btn');
    const chatInput = document.getElementById('chat_message_input') as HTMLInputElement;

    if (emojiBtn && chatInput) {
        const commonEmojis = ['😀', '😂', '😍', '🥰', '😊', '😎', '🤔', '😢', '😭', '😡', '👍', '👎', '❤️', '��', '✨', '🎉', '👏', '🙏', '💯', '✅'];

        emojiBtn.addEventListener('click', (e) => {
            e.preventDefault();

            const existingPicker = document.getElementById('emoji_picker_popup');
            if (existingPicker) {
                existingPicker.remove();
                return;
            }

            const picker = document.createElement('div');
            picker.id = 'emoji_picker_popup';
            picker.className = 'absolute bottom-full right-0 mb-2 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50';
            picker.style.width = '280px';
            picker.style.maxHeight = '200px';
            picker.style.overflowY = 'auto';

            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-8 gap-2';

            commonEmojis.forEach(emoji => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = emoji;
                btn.className = 'text-2xl hover:bg-gray-100 dark:hover:bg-gray-700 rounded p-1 transition-colors';
                btn.addEventListener('click', () => {
                    const cursorPos = chatInput.selectionStart || 0;
                    const currentValue = chatInput.value;
                    const newValue = currentValue.slice(0, cursorPos) + emoji + currentValue.slice(cursorPos);

                    chatInput.value = newValue;
                    chatInput.focus();
                    chatInput.setSelectionRange(cursorPos + emoji.length, cursorPos + emoji.length);
                    chatInput.dispatchEvent(new Event('input'));
                    picker.remove();
                });
                grid.appendChild(btn);
            });

            picker.appendChild(grid);
            emojiBtn.parentElement!.appendChild(picker);

            setTimeout(() => {
                document.addEventListener('click', function closePickerHandler(e) {
                    if (!picker.contains(e.target as Node) && e.target !== emojiBtn) {
                        picker.remove();
                        document.removeEventListener('click', closePickerHandler);
                    }
                });
            }, 100);
        });
    }
});

// Listen for UserOnline events
(window as any).Echo.channel('chat')
    .listen('.UserOnline', (event: any) => {
        console.log('[Chat] UserOnline event received:', event);

        const contactButtons = document.querySelectorAll('[wire\\:click*="selectContact"]');
        contactButtons.forEach((button) => {
            const wireClick = button.getAttribute('wire:click');
            const contactId = wireClick?.match(/selectContact\('(\d+)'\)/)?.[1];

            if (contactId && contactId === String(event.userId)) {
                const statusDot = button.querySelector('.bg-green-500');
                const statusText = button.querySelector('.text-xs');

                if (event.isOnline) {
                    if (!statusDot) {
                        const avatarDiv = button.querySelector('.relative');
                        if (avatarDiv) {
                            const dot = document.createElement('span');
                            dot.className = 'absolute bottom-0 right-0 size-3 rounded-full bg-green-500 border-2 border-white';
                            dot.title = 'Online';
                            avatarDiv.appendChild(dot);
                        }
                    }

                    if (statusText) {
                        statusText.textContent = 'Online';
                        statusText.className = 'text-xs text-green-600';
                    }
                } else {
                    if (statusDot) statusDot.remove();

                    if (statusText && event.lastSeen) {
                        statusText.textContent = event.lastSeen;
                        statusText.className = 'text-xs text-muted-foreground';
                    }
                }
            }
        });
    });
