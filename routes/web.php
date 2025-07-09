<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login as AuthLogin;

use App\Livewire\Inicio\Index as InicioIndex;

use App\Livewire\Perfil\Index as PerfilIndex;

//

Route::get('/login', AuthLogin::class)
    ->middleware('guest')
    ->name('login');

Route::redirect('/', '/inicio');

Route::get('/inicio', InicioIndex::class)
    ->middleware(['auth'])
    ->name('inicio.index');

Route::get('/perfil', PerfilIndex::class)
    ->middleware(['auth'])
    ->name('perfil.index');
