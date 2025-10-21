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
    public $showinAgendaModal = false;
    public $showinReporteModal = false;
    public $selectedSeguimientoId = null;

    public function render()
    {
        $query = seguimientosUsg::with('paciente','estado','usuarioHospital','usuarioUsg')
            ->when($this->filtroEstado, function($q){
                $q->where('EstadoProcesoId', $this->filtroEstado);
            })
            ->when($this->busquedaPaciente, function($q){
                $q->whereHas('paciente', function($subq){
                    $subq->where('nombrePaciente', 'like','%' . $this->busquedaPaciente . '%');
                });
            })
            ->orderBy('fechaAlta','desc');

            //para la paginacion de livewire
            $seguimientos = $query->paginate(10);

            return view('livewire.dasboard-seguimietos',[
                'seguimientos'=>$seguimientos,
                'estados'=> \App\Models\EstadoProceso::all(), //para el filtro
            ]);
    }

    //ACCIONES PARA LOS BOTONES DE LA TABLA
    public function openAgendaModal($seguimientosId){
        $this->selectedSeguimientoId = $seguimientosId;
        $this->showinAgendaModal = true;
    }

    public function openReporteModal($seguimientosId){
        $this->selectedSeguimientoId = $seguimientosId;
        $this->showinReporteModal = true;
    }

    //ESCUCHA EVENTOS DE LOS MODALES
    protected $listeners = [
        'citaAgendada' => 'closeModals',
        'reporteSubido' => 'closeModals'
    ];

    public function closeModals(){
        $this->showinAgendaModal = false;
        $this->showinReporteModal = false;
        $this->selectedSeguimientoId = null;
        $this->render();
    }
}
