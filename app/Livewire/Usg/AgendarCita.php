<?php

namespace App\Livewire\Usg;

use Livewire\Component;
use App\Models\seguimientosUsg;

class AgendarCita extends Component
{

    public $seguimientoId;
    public $fechaSeguimiento; //Fecha  y hora
    public $seguimiento;
    protected $rules = [
        'fechaSeguimiento' => 'required|date|after:now',
    ];

    public function mount($seguimientoId){
        $this->seguimientoId = $seguimientoId;
        $this->seguimiento = seguimientosUsg::find($this->seguimientoId);
    }

    public function saveAgenda(){
        $this->validate();

        $this->seguimiento->update([
            'fechaSeguimiento' => $this->fechaSeguimiento,
            'EstadoProcesoId' => 2, //ASUMIENDO QUE 2 = AGENDADO
        ]);

        $this->dispatch('citaAgendada');//Emite el evento para cerrar el modal
    }

    public function render()
    {
        return view('livewire.usg.agendar-cita');
    }
}
