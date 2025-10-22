<?php

namespace App\Livewire\Hospital;

use Livewire\Component;
use App\Models\paciente;

class AltaPaciente extends Component
{   
    public $nombrePaciente;
    public $dui = '';
    public $especie = '';
    public $sexo = '';

    protected $rules = [
        'nombrePaciente' => 'required|string|max: 255',
        'dui' => 'nullable|string|max:10|unique:pacientes,dui',
        'especie' => 'required|string|max:100',
        'sexo' => 'required|string|in:Macho,Hembra',
    ];

    public function savePaciente(){
        $this->validate();

        paciente::create([
            'nombrePaciente' => $this->nombrePaciente,
            'dui' => $this->dui,
            'especie' => $this->especie,
            'sexo' => $this->sexo
        ]);

        session()->flash('success','PX registrado exitosamente.');
        $this->reset(); //limpia el formulario
    }

    public function render(){
        return view('livewire.hospital.alta-paciente');
    }
}
