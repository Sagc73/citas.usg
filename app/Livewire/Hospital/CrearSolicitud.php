<?php

namespace App\Livewire\Hospital;

use Livewire\Component;
use App\Models\paciente;
use App\Models\seguimientosUsg;
use Illuminate\Support\Facades\Auth; 

class CrearSolicitud extends Component
{
    public $pacienteId = '';
    public $solicitud = ''; //motivo de la solicitud

    protected $rules = [
        'pacienteId' => 'required|exists:pacientes, PacienteId',
        'solicitud' => 'required|string|min:10',
    ];

    public function saveSolicitud(){
        $this->validate();

        seguimientosUsg::create([
            'PacienteId' => $this->pacienteId,
            'solicitud' => $this->solicitud,
            'fechaAlta' => now(),
            'EstadoProcesoId' => 1, //asumiendo que 1 es solicitado
            'UsuarioHospital' => Auth::user()->usuarioId,
        ]);

        session()->flash('success','Solicitud de ultrasonografia creada.');
        return redirect()->to('/dasboard');//redirige a la tabla principal
    }

    public function render()
    {
        //OBTENIENDO LOS PACIENTES PARA EL DROPDOWN
        $pacientes = paciente::orderBy('nombrePaciente','asc')->get();
        return view('livewire.hospital.crear-solicitud', [
            'pacientes' => $pacientes
        ]);
    }
}
