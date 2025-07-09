<?php

namespace App\Livewire\Components\CerrarSesion;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.components.cerrar-sesion.index');
    }

    public function cerrarSesion()
    {
        Auth::logout();

        return $this->redirect(route('login'), navigate: true);
    }
}
