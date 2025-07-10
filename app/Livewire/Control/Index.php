<?php

namespace App\Livewire\Control;

use App\Models\Control;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $buscar = '';

    public $foto1;
    public $foto2;
    public $placa;

    public $tipoFoto;

    public function render()
    {
        return view('livewire.control.index');
    }

    #[Computed()]
    public function controles()
    {
        $buscar = $this->buscar;
        return Control::query()
            ->with([
                'vehiculo' => function ($query) use ($buscar) {
                    $query->whereAny([
                        'placa',
                        DB::raw("CONCAT(apellido, ', ', nombre)"),
                        'marca',
                        'modelo',
                    ], 'like', '%' . $buscar . '%');
                }
            ])
            ->whereHas('vehiculo', function ($query) use ($buscar) {
                $query->whereAny([
                    'placa',
                    DB::raw("CONCAT(apellido, ', ', nombre)"),
                    'marca',
                    'modelo',
                ], 'like', '%' . $buscar . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function verFotos($id, $tipoFoto = 'ingreso')
    {
        $this->reset(['foto1', 'foto2', 'tipoFoto']);

        $control = Control::findOrFail($id);
        if (!$control) {
            $this->dispatch('toast', message: 'Control no encontrado', type: 'error');
            return;
        }

        $this->tipoFoto = $tipoFoto;

        $this->placa = $control->vehiculo->placa ?? 'Placa no disponible';

        if ($tipoFoto === 'ingreso') {
            $this->foto1 = $control->foto_ingreso;
            $this->foto2 = $control->foto_ingreso_2;
        } elseif ($tipoFoto === 'salida') {
            $this->foto1 = $control->foto_salida;
            $this->foto2 = $control->foto_salida_2;
        } else {
            $this->dispatch('toast', message: 'Tipo de foto no válido', type: 'error');
            return;
        }

        $this->modal('modal-ver-fotos')->show();
    }
}
