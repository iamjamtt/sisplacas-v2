<?php

namespace App\Livewire\Components\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public ?User $usuario;

    public function render()
    {
        return view('livewire.components.profile.index');
    }

    public function mount()
    {
        $this->usuario = Auth::user();
    }
}
