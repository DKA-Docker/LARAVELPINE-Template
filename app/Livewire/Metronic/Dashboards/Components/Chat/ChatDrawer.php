<?php

namespace App\Livewire\Metronic\Dashboards\Components\Chat;

use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class ChatDrawer extends Component
{
    public function render()
    {
        return view('dashboards.components.chat.chat-drawer');
    }

    public function placeholder()
    {
        return view('dashboards.components.chat.chat-drawer-skeleton');
    }
}
