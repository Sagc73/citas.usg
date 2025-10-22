<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\seguimientosUsg;
use Livewire\WithPagination;

class DashboardSeguimientos extends Component
{
    use WithPagination;

    public $filtroEstado = '';
    public $busquedaPaciente = '';

    //variables para los modales
    public $showingAgendaModal = false;
    public $showingReporteModal = false;
    public $selectedSeguimientoId = null;

    public function render()
    {
        $query = seguimientosUsg::with('paciente', 'estado', 'usuarioHospital', 'usuarioUsg')
            ->when($this->filtroEstado, function ($q) {
                $q->where('EstadoProcesoId', $this->filtroEstado);
            })
            ->when($this->busquedaPaciente, function ($q) {
                $q->whereHas('paciente', function ($subq) {
                    $subq->where('nombrePaciente', 'like', '%' . $this->busquedaPaciente . '%');
                });
            })
            ->orderBy('fechaAlta', 'desc');

        //para la paginacion de livewire
        $seguimientos = $query->paginate(10);

       return view('livewire.dashboard-seguimientos', [
            'seguimientos' => $seguimientos,
            'estados' => \App\Models\EstadoProceso::all(), // Para el filtro
        ]);
    }

    //ACCIONES PARA LOS BOTONES DE LA TABLA
    public function openAgendaModal($seguimientosId)
    {
        $this->selectedSeguimientoId = $seguimientosId;
        $this->showingAgendaModal = true;
    }

    public function openReporteModal($seguimientosId)
    {
        $this->selectedSeguimientoId = $seguimientosId;
        $this->showingReporteModal = true;
    }

    //ESCUCHA EVENTOS DE LOS MODALES
    protected $listeners = [
        'citaAgendada' => 'closeModals',
        'reporteSubido' => 'closeModals'
    ];

    public function closeModals()
    {
        $this->showingAgendaModal = false;
        $this->showingReporteModal = false;
        $this->selectedSeguimientoId = null;
        $this->render();
    }
}
