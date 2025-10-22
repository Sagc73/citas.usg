<?php

namespace App\Livewire\Usg;

use Livewire\Component;
use App\Models\seguimientosUsg;
use App\Models\ArchivoAdjunto;
use Livewire\WithFileUploads; //LIBRERIA PARA SUBIR ARCHIVOS
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubirReporte extends Component
{   
    use WithFileUploads;
    
    public $seguimientoId;
    public $seguimiento;
    public $observaciones = ''; //EL REPORTE ESCRITO
    public $archivo; // el archivo PDF/JPG 

    protected $rules = [
        'observaciones' => 'required|string|min:20',
        'archivo' => 'nullable|file|mimes:pdf,jpg,png|max:10240', //maximo 10 mb
    ];

    public function moount($seguimientoId){
        $this->seguimientoId = $seguimientoId;
        $this->seguimiento = seguimientosUsg::find($this->seguimientoId);
        $this->observaciones = $this->seguimiento->observaciones; //carga si ya existe
    }
    public function saveReporte(){
        $this->validate();

        //1. ACTUALIZA EL SEGUIMIENTO REPORTE ESCRITO Y ESTADO
        $this->seguimiento->update([
            'observaciones' => $this->observaciones,
            'UsuarioUsg' => Auth::user()->usuarioId,
            'EstadoProcesoId' => 4, //asumiendo que los resultados estan listos
        ]);

        //2. si se subio un archivo, guardalo
        if($this->archivo){
            //guardando el archivo en 'storage/app/public/reportes
            $ruta = $this->archivo->store('reportes','public');
            //creando el registro en la base de datos
            ArchivoAdjunto::create([
                'SeguimientoId' => $this->seguimientoId,
                'nombreArchivo' => $this->archivo->getClientOriginalName(),
                'rutaArchivo' => $ruta,
                'tipoArchivo' => $this->archivo->getMimeType(),
                'fechaCarga' => now(),
            ]);
        }
        $this->dispatch('reporteSubido');//emite evento para cerrar el modal
    }
    public function render()
    {
        return view('livewire.usg.subir-reporte');
    }
}
