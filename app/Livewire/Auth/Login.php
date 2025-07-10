<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Login')]
#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $correo_electronico = '';
    #[Validate('required')]
    public string $contrasena = '';

    #[Validate('nullable|boolean')]
    public bool $recuerdame = false;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate([
            'correo_electronico' => 'required|email',
            'contrasena' => 'required',
        ]);

        $usuario = User::query()
            ->where('email', $this->correo_electronico)
            ->first();

        if (!$usuario) {
            $this->dispatch('toast', message: 'Sus credenciales no son correctas', type: 'error');
            return;
        }

        if (!Hash::check($this->contrasena, $usuario->password)) {
            $this->dispatch('toast', message: 'Sus credenciales no son correctas', type: 'error');
            return;
        }

        Auth::login($usuario, remember: $this->recuerdame);

        $mensaje = 'Bienvenido ' . $usuario->name . ', ha iniciado sesión correctamente.';
        $this->dispatch('toast', message: $mensaje, type: 'success');

        return $this->redirectIntended(route('inicio.index'), navigate: true);
    }
}
