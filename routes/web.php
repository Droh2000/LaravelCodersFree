<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
    En lugar de usar esta ruta mejor vamos a usar la de admin.dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
*/

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Definimos esta ruta solo para ver como podemos copiar un archivo hacia otra carpeta
Route::get('/prueba', function () {
    $path = "RUTA/Nombre.extencion";
    $target = "NUEVA_RUTA/Nombre.extencion"; // Aqui le podramos dar otro nombre

    // Storage::copy($path, $target);

    // Si queremos mover el archivo
    Storage::move($path, $target);

    return 'Imagen copiada';
});

// Aqui en el archivo de rutas podemos ver que esta llamando a este archivo (Este tambien contiene Rutas)
require __DIR__.'/auth.php';
