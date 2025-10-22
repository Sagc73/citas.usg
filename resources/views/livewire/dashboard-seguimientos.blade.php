<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Panel de Seguimiento de Ultrasonografías</h1>

    <div class="flex space-x-4 mb-4">
        <input wire:model.live.debounce.300ms="busquedaPaciente" type="text" placeholder="Buscar por nombre de paciente..." class="border p-2 rounded w-1/3">
        <select wire:model.live="filtroEstado" class="border p-2 rounded">
            <option value="">Todos los Estados</option>
            @foreach($estados as $estado)
            <option value="{{ $estado->EstadoProcesoId }}">{{ $estado->nombreEstado }}</option>
            @endforeach
        </select>
    </div>

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Paciente</th>
                <th class="border p-2">Solicitud</th>
                <th class="border p-2">Fecha Solicitud</th>
                <th class="border p-2">Fecha Agendada</th>
                <th class="border p-2">Estado</th>
                <th class="border p-2">Solicitó (Hospital)</th>
                <th class="border p-2">Atendió (USG)</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seguimientos as $seg)
            <tr wire:key="{{ $seg->SeguimientoId }}">
                <td class="border p-2">{{ $seg->paciente->nombrePaciente ?? 'N/A' }}</td>
                <td class="border p-2">{{ Str::limit($seg->solicitud, 30) }}</td>
                <td class="border p-2">{{ $seg->fechaAlta->format('d/m/Y') }}</td>
                <td class="border p-2">{{ $seg->fechaSeguimiento ? $seg->fechaSeguimiento->format('d/m/Y H:i') : 'No agendado' }}</td>
                <td class="border p-2">
                    <span class="px-2 py-1 rounded text-white">
                        {{ $seg->estado->nombreEstado ?? 'N/A' }}
                    </span>
                </td>
                <td class="border p-2">{{ $seg->usuarioHospital->nombreUsuario ?? 'N/A' }}</td>
                <td class="border p-2">{{ $seg->usuarioUsg->nombreUsuario ?? 'N/A' }}</td>
                <td class="border p-2">
                    @if(auth()->user()->rol->nombreRol == 'Ultrasonografia')
                    @if($seg->EstadoProcesoId == 1) <button wire:click="openAgendaModal({{ $seg->SeguimientoId }})" class="bg-blue-500 text-white px-2 py-1 rounded">Agendar</button>
                    @endif

                    @if($seg->EstadoProcesoId == 2) <button wire:click="openReporteModal({{ $seg->SeguimientoId }})" class="bg-green-500 text-white px-2 py-1 rounded">Subir Reporte</button>
                    @endif
                    @endif

                    @if($seg->EstadoProcesoId == 4) <button wire:click="openReporteModal({{ $seg->SeguimientoId }})" class="bg-gray-500 text-white px-2 py-1 rounded">Ver Reporte</button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="border p-4 text-center">No se encontraron seguimientos.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $seguimientos->links() }}
    </div>

    @if($showingAgendaModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h3 class="text-lg font-bold mb-4">Agendar Cita (ID: {{ $selectedSeguimientoId }})</h3>
            @livewire('usg.agendar-cita', ['seguimientoId' => $selectedSeguimientoId], key('agenda-'.$selectedSeguimientoId))
            <button wire:click="closeModals" class="mt-4 text-gray-600">Cerrar</button>
        </div>
    </div>
    @endif

    @if($showingReporteModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
            <h3 class="text-lg font-bold mb-4">Gestión de Reporte (ID: {{ $selectedSeguimientoId }})</h3>
            @livewire('usg.subir-reporte', ['seguimientoId' => $selectedSeguimientoId], key('reporte-'.$selectedSeguimientoId))
            <button wire:click="closeModals" class="mt-4 text-gray-600">Cerrar</button>
        </div>
    </div>
    @endif
</div>