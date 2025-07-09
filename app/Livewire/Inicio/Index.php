<?php

namespace App\Livewire\Inicio;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Inicio | REGISTROS ACADEMICOS UNIA')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.inicio.index');
    }
}
