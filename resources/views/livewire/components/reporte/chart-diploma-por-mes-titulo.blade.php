<x-card>
    <x-card.body>
        <flux:text class="text-base md:text-md !font-semibold mb-4">
            Diplomas verificados de los últimos 4 meses
        </flux:text>
        <div id="chartTotalDiplomasTitulo" class="w-full h-[300px] m-0"></div>
    </x-card.body>
</x-card>

@script
<script>
    let chartTotalDiplomasTitulo = null;

    function renderChartTotalDiplomasTitulo() {
        const isDarkMode = document.documentElement.classList.contains('dark');

        const chartElement = document.getElementById('chartTotalDiplomasTitulo');
        if (!chartElement) return; // prevenir errores si no existe

        const options = {
            series: [{
                name: 'Diplomas verificados',
                data: @js($totalDiplomasMes)
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                },
                dataLabels: {
                    position: 'top'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @js($meses),
                labels: {
                    style: {
                        colors: isDarkMode ? '#e4e4e7' : '#27272a'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'TOTAL DIPLOMAS DE TÍTULO PROFESIONAL',
                    style: {
                        color: isDarkMode ? '#e4e4e7' : '#27272a'
                    }
                },
                labels: {
                    style: {
                        colors: isDarkMode ? '#e4e4e7' : '#27272a'
                    }
                }
            },
            tooltip: {
                theme: isDarkMode ? 'dark' : 'light',
                y: {
                    formatter: function (val) {
                        return val;
                    }
                }
            },
            fill: {
                opacity: 1
            }
        };

        if (chartTotalDiplomasTitulo) {
            chartTotalDiplomasTitulo.destroy();
        }

        chartTotalDiplomasTitulo = new ApexCharts(chartElement, options);
        chartTotalDiplomasTitulo.render();
    }

    // ✅ Usar window.onload para asegurar que todo el DOM y estilos estén cargados
    window.onload = () => {
        renderChartTotalDiplomasTitulo();
    };

    // 🔁 Observar cambios en el modo oscuro
    const observer = new MutationObserver(() => {
        renderChartTotalDiplomasTitulo();
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });

    // 🔁 Escuchar navegación de Livewire
    window.addEventListener('livewire:navigated', () => {
        renderChartTotalDiplomasTitulo();
    });
</script>
@endscript
