<?php

namespace App\Livewire\Metronic\Dashboards\Components\Chat;

use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class ChatDrawer extends Component
{
    public $messageBody = '';
    public $messages = [];
    public $typingUsers = []; // Track who is typing
    public $selectedReceiverId = null; // Selected contact to chat with
    public $contacts = []; // List of available contacts

    public function mount()
    {
        // Update current user's last_seen_at
        auth()->user()->update(['last_seen_at' => now()]);
        
        // Broadcast that user is online
        broadcast(new \App\Events\Chats\UserOnline(
            userId: (int) auth()->id(),
            isOnline: true,
            lastSeen: now()->toIso8601String()
        ));
        
        // Load available contacts (all users except current user)
        $this->contacts = \App\Models\Base\Accounts\Accounts::where('id', '!=', auth()->id())
            ->with('information')
            ->get()
            ->map(function($user) {
                $info = $user->getRelationValue('information');
                $firstName = '';
                $lastName = '';
                
                // Check if information exists (has ID means it's real data, not withDefault)
                if ($info && isset($info->id)) {
                    $firstName = $info->first_name ?? '';
                    $lastName = $info->last_name ?? '';
                }
                
                $fullName = trim($firstName . ' ' . $lastName);
                
                return [
                    'id' => $user->id,
                    'name' => !empty($fullName) ? $fullName : 'Unknown User',
                    'avatar' => '/storage/media/avatars/300-5.png',
                    'isOnline' => $this->isUserOnline($user->last_seen_at),
                    'lastSeen' => $user->last_seen_at?->diffForHumans(),
                ];
            })
            ->toArray();
        
        // Load messages if a receiver is selected
        $this->loadMessages();
    }
    
    public function loadMessages()
    {
        if (!$this->selectedReceiverId) {
            $this->messages = [];
            return;
        }
        
        // Load messages between current user and selected receiver
        $this->messages = \App\Models\Base\Chats\Message::with('sender')
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('user_id', auth()->id())
                      ->where('receiver_id', $this->selectedReceiverId);
                })
                ->orWhere(function($q) {
                    $q->where('user_id', $this->selectedReceiverId)
                      ->where('receiver_id', auth()->id());
                });
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
    }
    
    public function selectContact($receiverId)
    {
        // Update last_seen_at on activity
        auth()->user()->update(['last_seen_at' => now()]);
        
        $this->selectedReceiverId = $receiverId;
        $this->loadMessages();
        
        // Dispatch event to JavaScript to update selectedReceiverId
        $this->dispatch('contact-selected', receiverId: $receiverId);
        
        // Broadcast online status
        broadcast(new \App\Events\Chats\UserOnline(
            userId: (int) auth()->id(),
            isOnline: true,
            lastSeen: now()->toIso8601String()
        ));
    }

    public function render()
    {
        return view('dashboards.components.chat.chat-drawer');
    }

    public function placeholder()
    {
        return view('dashboards.components.chat.chat-drawer-skeleton');
    }

    public function updatedMessageBody()
    {
        // Only broadcast typing event if message body has content
        // Don't broadcast if empty (which happens after sending)
        if (!empty(trim($this->messageBody)) && strlen(trim($this->messageBody)) > 0) {
            broadcast(new \App\Events\Chats\UserTyping(auth()->user()))->toOthers();
        }
    }

    public function sendMessage()
    {
        if (!$this->selectedReceiverId) {
            $this->dispatch('error', 'Please select a contact first');
            return;
        }
        
        $this->validate([
            'messageBody' => 'required|string|max:1000',
        ]);

        $message = \App\Models\Base\Chats\Message::create([
            'user_id' => auth()->id(),
            'receiver_id' => $this->selectedReceiverId,
            'body' => $this->messageBody,
        ]);

        broadcast(new \App\Events\Chats\MessageSent($message))->toOthers();

        $this->messages[] = $message->load('sender')->toArray();
        $this->messageBody = '';
    }

    /**
     * Listen for incoming messages on the public 'chat' channel.
     * Event name must match the broadcast alias or class name (if no alias).
     * Laravel Echo usually expects the full class name for events unless aliased.
     * Default Reverb/Pusher event name for `App\Events\Chats\MessageSent` is `.App.Events.Chats.MessageSent` (with leading dot often inferred)
     * OR just `MessageSent` if namespace is omitted in Echo client, but standard is fully qualified.
     * 
     * Livewire attribute format: #[On('echo:{channel},{event}')]
     */
    //     #[\Livewire\Attributes\On('echo:chat,.App.Events.Chats.MessageSent')]
    public function onMessageSent($event)
    {
        // $event is the payload broadcasted
        // We might need to fetch the message or just push the payload if it matches structure
        // Usually event payload contains the public properties of the Event class.
        // MessageSent has public $message.
        
        // Safety check to avoid duplicating own message if broadcast(..)->toOthers() didn't catch it 
        // (Echo listener in Livewire receives it even if sent by self if not carefully excluded, 
        // but toOthers() excludes the socket ID. Livewire listener is server-side triggered by client-side Echo? 
        // No, Livewire Echo listener is client-side Echo receiving it, then triggering a Livewire roundtrip.
        
        $newMessage = $event['message'];
        
        // Eager load sender if not present in payload (it might be if model was serialized with it, but standard serialization is just model attributes)
        // Better to fetch fresh or rely on what's sent.
        // For simplicity, let's just append.
        
        // Ensure we don't duplicate if we just sent it (though toOthers should handle the socket exclusion)
        // Only add message if it's part of current conversation
        if (isset($newMessage['user_id']) && isset($newMessage['receiver_id'])) {
            $isForMe = ($newMessage['receiver_id'] == auth()->id() && $newMessage['user_id'] == $this->selectedReceiverId);
            $isFromMe = ($newMessage['user_id'] == auth()->id() && $newMessage['receiver_id'] == $this->selectedReceiverId);
            
            if ($isForMe || $isFromMe) {
                $msgModel = \App\Models\Base\Chats\Message::with('sender')->find($newMessage['id']);
                if ($msgModel) {
                    $this->messages[] = $msgModel->toArray();
                }
            }
        }
    }
    
    /**
     * Check if user is online (last seen within 5 minutes)
     */
    private function isUserOnline($lastSeenAt): bool
    {
        if (!$lastSeenAt) {
            return false;
        }
        
        return $lastSeenAt->diffInMinutes(now()) < 5;
    }
}
