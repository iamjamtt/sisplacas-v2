<?php

namespace App\Livewire\Inicio;

use App\Models\Control;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Inicio | REGISTROS ACADEMICOS UNIA')]
class Index extends Component
{
    public $vehiculos_count;
    public $control_days_count;
    public $control_week_count;
    public $control_month_count;

    public function render()
    {
        return view('livewire.inicio.index');
    }

    public function mount()
    {
        $this->vehiculos_count = Vehiculo::count();
        $this->control_days_count = Control::where('fecha', today())->count();
        $this->control_week_count = Control::whereBetween('fecha', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $this->control_month_count = Control::whereMonth('fecha', Carbon::now()->month)->count();
    }

    #[Computed()]
    public function getDataChart()
    {
        // quiero un control de los ultimos 6 dias y me de la cantidad de vehiculos registrados por dia
        // y que me retorne un array con la fecha como clave y la cantidad de registros
        // Ejemplo: ['2023-10-01' => 5, '2023-10-02' => 10, ...]
        // en caso no haya registros en un dia, que el valor sea 0
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[$date] = 0; // Inicializa con 0
        }
        // Obtiene los registros de los últimos 6 días
        $records = Control::selectRaw('DATE(fecha) as date, COUNT(*) as count')
            ->where('fecha', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Recorre los registros y actualiza el array con la cantidad de registros por fecha
        foreach ($records as $record) {
            $date = $record->date;
            $count = $record->count;
            if (isset($data[$date])) {
                $data[$date] = $count; // Actualiza la cantidad de registros para esa fecha
            }
        }

        return $data;
    }
}
