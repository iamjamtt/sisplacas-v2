<?php

namespace App\Livewire\Components\Profile;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public ?Usuario $usuario;

    public function render()
    {
        return view('livewire.components.profile.index');
    }

    public function mount()
    {
        $this->usuario = Auth::user();
    }
}
