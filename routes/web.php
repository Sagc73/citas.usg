<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DashboardSeguimientos;
use App\Livewire\Hospital\AltaPaciente;
use App\Livewire\Hospital\CrearSolicitud;

Route::get('/', function(){
    return view('welcome');
});

//rutas protegidas que requiere login
route::middleware(['auth'])->group(function(){
    //DASHBOARD PRINCIPAL AMBOS ROLES PUEDEN VER
    Route::get('dashboard', DashboardSeguimientos::class)
        ->name('dasboard');
    
    //RUTAS SOLO PARA HOSPITAL
    Route::middleware(['role:Hospital'])->group(function(){
        Route::get('/pacientes/nuevo', AltaPaciente::class)
            ->name('hospital.pacientes.crear');

        Route::get('/solicitudes/nueva', CrearSolicitud::class)
            ->name('hospital.solicitudes.crear');
    });
});