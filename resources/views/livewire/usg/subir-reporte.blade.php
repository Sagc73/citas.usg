<div>
    <p class="mb-2">Paciente: <strong>{{ $seguimiento->paciente->nombrePaciente ?? 'N/A' }}</strong></p>
    
    @php
        $puedeEditar = auth()->user()->rol->nombreRol == 'Ultrasonografia' && $seguimiento->EstadoProcesoId != 4;
        $esAdminUSG = auth()->user()->rol->nombreRol == 'Ultrasonografia';
        $tieneResultados = $seguimiento->EstadoProcesoId == 4;
    @endphp

    <form wire:submit.prevent="saveReporte">
        <div class="mb-4">
            <label for="observaciones" class="block text-sm font-medium text-gray-700">Reporte / Observaciones de Ultrasonografía</label>
            <textarea wire:model="observaciones" id="observaciones" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                @if(!$esAdminUSG) readonly @endif >
            </textarea>
            @error('observaciones') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        @if($esAdminUSG)
            <div class="mb-4">
                <label for="archivo" class="block text-sm font-medium text-gray-700">Adjuntar Archivo (PDF, JPG, PNG)</label>
                <input wire:model="archivo" type="file" id="archivo" class="mt-1 block w-full">
                @error('archivo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                
                <div wire:loading wire:target="archivo" class="text-sm text-blue-500 mt-1">Cargando...</div>
            </div>
        @endif

        @if($tieneResultados && $seguimiento->archivos->count() > 0)
            <div class="mb-4">
                <h4 class="font-semibold">Archivos Adjuntos:</h4>
                <ul class="list-disc list-inside">
                    @foreach($seguimiento->archivos as $file)
                        <li>
                            <a href="{{ Storage::url($file->rutaArchivo) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $file->nombreArchivo }} (Subido: {{ $file->fechaCarga->format('d/m/Y') }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if($esAdminUSG)
             <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded font-bold w-full">
                {{ $tieneResultados ? 'Actualizar Reporte' : 'Guardar y Finalizar Reporte' }}
             </button>
        @endif
    </form>
</div>