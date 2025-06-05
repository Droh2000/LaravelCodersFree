<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Aqui tenemos todas las rutas definidas del sistema de login y registro
// Pero pasa que la forma en la que esta llamando a las rutas no es la forma tradicional, Aqui estan usando VOLT
// aunque aqui vamos a nombrar las ruta de la manera tradicional
// Con VOLT le estamos diciendo que en lugar de asignarle el control de la ruta al controlado, se le asigna a un componente de VOLT
// ese componente se llama "auth.login, auth.register, auth.forgot-password, etc", "auth" es la carpeta y lo demas el nombre del archivo
// estos componentes son una espiece de componentes de LiveWired solamente que contienen un archivo que es la vista
// Resources/view/livewire/auth
Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Volt::route('register', 'auth.register')
        ->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');

});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
