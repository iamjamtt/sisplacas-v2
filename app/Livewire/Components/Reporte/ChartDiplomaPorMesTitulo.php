<?php

namespace App\Livewire\Components\Reporte;

use App\Enums\EstadoRegistroEnum;
use App\Models\GradoAcademico;
use App\Models\Registros;
use Livewire\Component;

class ChartDiplomaPorMesTitulo extends Component
{
    public $id_gac;
    public ?GradoAcademico $gradoAcademico;

    public array $meses = [];
    public array $totalDiplomasMes = [];

    public function render()
    {
        return view('livewire.components.reporte.chart-diploma-por-mes-titulo');
    }

    public function mount()
    {
        $this->id_gac = 2;
        $this->gradoAcademico = GradoAcademico::find($this->id_gac);

        // Cargar los ultimos 4 meses en español
        $this->meses = [
            mb_ucfirst(now()->subMonth(3)->locale('es')->translatedFormat('F')),
            mb_ucfirst(now()->subMonth(2)->locale('es')->translatedFormat('F')),
            mb_ucfirst(now()->subMonth(1)->locale('es')->translatedFormat('F')),
            mb_ucfirst(now()->locale('es')->translatedFormat('F')),
        ];

        // Cargar los totales de los ultimos 4 meses
        $this->totalDiplomasMes = [
            Registros::query()
                ->where('creado_en_reg', '>=', now()->subMonth(3)->startOfMonth())
                ->where('creado_en_reg', '<=', now()->subMonth(3)->endOfMonth())
                ->where('id_gac', $this->gradoAcademico->id_gac)
                ->where('estado_reg', EstadoRegistroEnum::ACTIVO)
                ->count(),
            Registros::query()
                ->where('creado_en_reg', '>=', now()->subMonth(2)->startOfMonth())
                ->where('creado_en_reg', '<=', now()->subMonth(2)->endOfMonth())
                ->where('id_gac', $this->gradoAcademico->id_gac)
                ->where('estado_reg', EstadoRegistroEnum::ACTIVO)
                ->count(),
            Registros::query()
                ->where('creado_en_reg', '>=', now()->subMonth(1)->startOfMonth())
                ->where('creado_en_reg', '<=', now()->subMonth(1)->endOfMonth())
                ->where('id_gac', $this->gradoAcademico->id_gac)
                ->where('estado_reg', EstadoRegistroEnum::ACTIVO)
                ->count(),
            Registros::query()
                ->where('creado_en_reg', '>=', now()->startOfMonth())
                ->where('creado_en_reg', '<=', now()->endOfMonth())
                ->where('id_gac', $this->gradoAcademico->id_gac)
                ->where('estado_reg', EstadoRegistroEnum::ACTIVO)
                ->count(),
        ];

        $this->dispatch('loadChartDiplomaPorMes');
    }
}
