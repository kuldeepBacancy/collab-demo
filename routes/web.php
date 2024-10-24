<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group([
        'prefix' => 'vehicles'
    ], function(){
        Route::get('/', App\Livewire\Vehicle\Index::class)->name('vehicles.index');
        Route::get('/create', App\Livewire\Vehicle\Create::class)->name('vehicles.create');
        // Route::get('/edit/{id}', App\Livewire\Vehicle\Edit::class)->name('vehicles.edit');
    });
});
