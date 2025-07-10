<?php

namespace App\Livewire\Vehiculo;

use App\Models\TipoSancion;
use App\Models\Vehiculo;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Gestion de Vehículos')]
class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $buscar = '';

    #[Validate('required|min:6|max:6', as: 'número de placa')]
    public string $placa = '';
    #[Validate('required', as: 'apellido')]
    public string $apellido = '';
    #[Validate('required', as: 'nombre')]
    public string $nombre = '';
    #[Validate('required', as: 'marca')]
    public string $marca = '';
    #[Validate('required', as: 'modelo')]
    public string $modelo = '';
    #[Validate('required|boolean', as: 'tiene sanción')]
    public bool $tieneSancion = false;
    #[Validate('nullable|integer', as: 'sanción')]
    public ?int $sancion = null;

    public bool $modalEditar = false;

    public ?Vehiculo $vehiculo;

    public function render()
    {
        return view('livewire.vehiculo.index');
    }

    #[Computed()]
    public function vehiculos()
    {
        return Vehiculo::query()
            ->when($this->buscar, function ($query) {
                $query->whereAny([
                    'placa',
                    DB::raw("CONCAT(apellido, ', ', nombre)"),
                    'marca',
                    'modelo',
                ], 'like', '%' . $this->buscar . '%');
            })
            ->with('sancion')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    #[Computed()]
    public function sanciones()
    {
        return TipoSancion::query()
            ->orderBy('id', 'desc')
            ->get();
    }

    public function updatedBuscar()
    {
        $this->resetPage();
    }

    public function updatedTieneSancion($value): void
    {
        if (!$value) {
            $this->sancion = null;
        }
    }

    public function limpiar(): void
    {
        $this->reset([
            'placa',
            'apellido',
            'nombre',
            'marca',
            'modelo',
            'tieneSancion',
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function cargarData($id = null, $modalEditar = false): void
    {
        $this->limpiar();
        $this->modalEditar = $modalEditar;

        if ($modalEditar) {
            $this->vehiculo = Vehiculo::findOrFail($id);
            $this->placa = $this->vehiculo->placa;
            $this->apellido = $this->vehiculo->apellido;
            $this->nombre = $this->vehiculo->nombre;
            $this->marca = $this->vehiculo->marca;
            $this->modelo = $this->vehiculo->modelo;
            $this->tieneSancion = $this->vehiculo->tieneSancion;
            $this->sancion = $this->vehiculo->id_tipes_sanctions ?? null;
        } else {
            $this->vehiculo = new Vehiculo();
        }

        $this->modal('modal-vehiculo')->show();
    }

    public function guardar(): void
    {
        $this->validate();

        $this->apellido = mb_strtoupper($this->apellido);
        $this->nombre = mb_strtoupper($this->nombre);
        $this->marca = mb_strtoupper($this->marca);
        $this->modelo = mb_strtoupper($this->modelo);

        try {
            DB::beginTransaction();

            if ($this->modalEditar == false) {
                $this->vehiculo = new Vehiculo();
            }
            $this->vehiculo->placa = $this->placa;
            $this->vehiculo->apellido = $this->apellido;
            $this->vehiculo->nombre = $this->nombre;
            $this->vehiculo->nombre_completo = $this->apellido . ', ' . $this->nombre;
            $this->vehiculo->marca = $this->marca;
            $this->vehiculo->modelo = $this->modelo;
            $this->vehiculo->tieneSancion = $this->tieneSancion;
            $this->vehiculo->id_tipes_sanctions = $this->tieneSancion ? $this->sancion : null;
            if ($this->modalEditar == false) {
                $this->vehiculo->estado = true;
            }
            $this->vehiculo->save();

            DB::commit();

            $this->limpiar();

            $this->modal('modal-vehiculo')->close();

            if ($this->modalEditar) {
                $this->dispatch('toast', message: 'Se ha actualizado el registro con exito', type: 'success');
            } else {
                $this->dispatch('toast', message: 'Se ha creado el registro con exito', type: 'success');
            }
        } catch (Exception $e) {
            DB::rollBack();

            $this->modal('modal-vehiculo')->close();

            $this->dispatch('toast', message: 'Error al generar el QR:' . $e->getMessage(), type: 'error');
        }
    }

    public function cambiarEstado(Vehiculo $vehiculo): void
    {
        try {
            DB::beginTransaction();

            $vehiculo->estado = !$vehiculo->estado;
            $vehiculo->save();

            DB::commit();

            $this->modal('modal-estado-'. $vehiculo->id)->close();

            $this->dispatch('toast', message: 'Se ha cambiado el estado del registro con exito', type: 'success');
        } catch (Exception $e) {
            DB::rollBack();

            $this->modal('modal-estado-'. $vehiculo->id)->close();

            $this->dispatch('toast', message: 'Error al cambiar el estado del registro:' . $e->getMessage(), type: 'error');
        }
    }

    public function eliminar(Vehiculo $vehiculo): void
    {
        try {
            DB::beginTransaction();

            if ($vehiculo->controles()->exists()) {
                throw new Exception('No se puede eliminar el vehículo porque tiene controles asociados.');
            }

            $vehiculo->delete();

            DB::commit();

            $this->modal('modal-eliminar-'. $vehiculo->id)->close();

            $this->dispatch('toast', message: 'Se ha eliminado el registro con exito', type: 'success');
        } catch (Exception $e) {
            DB::rollBack();

            $this->modal('modal-eliminar-'. $vehiculo->id)->close();

            $this->dispatch('toast', message: 'Error al eliminar el registro:' . $e->getMessage(), type: 'error');
        }
    }
}
