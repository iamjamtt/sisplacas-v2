<?php

namespace App\Livewire\Perfil;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

// #[Lazy()]
#[Title('Mi perfil | REGISTROS ACADEMICOS UNIA')]
class Index extends Component
{
    use WithFileUploads;

    public ?Usuario $usuario;

    #[Url(except: 'perfil', as: 'tab')]
    public string $tab = 'perfil';

    //
    #[Validate('nullable|image|max:4096')]
    public $foto;
    #[Validate('required|string|max:100')]
    public $nombre;
    //
    #[Validate('required', as: 'contraseña actual')]
    public $password;
    #[Validate('required|string|min:8|max:20', as: 'nueva contraseña')]
    public $nueva_contrasena;

    public function render()
    {
        return view('livewire.perfil.index');
    }

    public function mount()
    {
        $this->usuario = Auth::user();
        $this->nombre = $this->usuario->nombre_usu;
    }

    public function asignarTab(string $tab)
    {
        $this->tab = $tab;
    }

    public function restablecerPerfil()
    {
        $this->reset(['foto', 'nombre']);
        $this->nombre = $this->usuario->nombre_usu;
        $this->dispatch('toast', message: 'Los cambios han sido cancelados', type: 'info');
    }

    public function guardarPerfil()
    {
        $this->validate([
            'nombre' => 'required|string|max:100',
            'foto' => 'nullable|image|max:4096',
        ]);

        if ($this->foto) {
            $folders = [
                'avatars',
            ];
            $ruta_archivo = $this->usuario->avatar_usu ?? null;
            $this->usuario->avatar_usu = subirArchivo($this->foto, $ruta_archivo, $folders);
        }

        $this->usuario->nombre_usu = $this->nombre;
        $this->usuario->save();

        $this->dispatch('toast', message: 'Perfil actualizado correctamente', type: 'success');
    }

    public function restablecerPerfilSeguridad()
    {
        $this->reset(['password', 'nueva_contrasena']);
        $this->dispatch('toast', message: 'Los cambios han sido cancelados', type: 'info');
    }

    public function guardarPerfilSeguridad()
    {
        $this->validate([
            'password' => 'required',
            'nueva_contrasena' => 'required|string|min:8|max:20',
        ]);

        if (Hash::check($this->password, $this->usuario->contrasena_usu)) {
            $this->usuario->contrasena_usu = Hash::make($this->nueva_contrasena);
            $this->usuario->save();
        } else {
            $this->dispatch('toast', message: 'La contraseña actual no es correcta', type: 'error');
            return;
        }

        $this->reset(['password', 'nueva_contrasena']);

        $this->dispatch('toast', message: 'Perfil actualizado correctamente', type: 'success');
    }
}
