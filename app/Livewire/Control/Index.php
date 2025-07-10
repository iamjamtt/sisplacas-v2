<?php

namespace App\Livewire\Control;

use App\Exports\ReporteControlExport;
use App\Models\Control;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $buscar = '';

    #[Url(except: null, as: 'f_fecha')]
    public $filtroFecha;

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
            ->when($this->filtroFecha, function ($query) {
                $query->whereDate('fecha', '=', $this->filtroFecha);
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

    public function exportar()
    {
        try {
            $nombreArchivo = 'reporte_control_' . now()->format('Ymd_His') . '.xlsx';
            $this->dispatch('toast', message: 'Reporte generado exitosamente', type: 'success');
            return Excel::download(new ReporteControlExport($this->filtroFecha), $nombreArchivo);
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Error al generar el reporte: ' . $e->getMessage(), type: 'error');
            return;
        }
    }
}
