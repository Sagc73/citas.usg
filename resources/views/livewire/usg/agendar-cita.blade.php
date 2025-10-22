<div>
    <p class="mb-2">Paciente: <strong>{{ $seguimiento->paciente->nombrePaciente ?? 'N/A' }}</strong></p>
    <p class="mb-4">Solicitud: <em class="text-gray-600">{{ $seguimiento->solicitud }}</em></p>

    <form wire:submit.prevent="saveAgenda">
        <div class="mb-4">
            <label for="fechaSeguimiento" class="block text-sm font-medium text-gray-700">Seleccionar Fecha y Hora</label>
            <input wire:model="fechaSeguimiento" type="datetime-local" id="fechaSeguimiento" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('fechaSeguimiento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold w-full">Confirmar Agenda</button>
    </form>
</div>