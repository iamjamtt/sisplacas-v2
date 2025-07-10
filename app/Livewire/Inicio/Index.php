<?php

namespace App\Livewire\Inicio;

use App\Models\Control;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Inicio | REGISTROS ACADEMICOS UNIA')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.inicio.index');
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
