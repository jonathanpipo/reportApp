<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', \App\Http\Livewire\Home::class)->name("Home");

Route::get('/heat-map', \App\Http\Livewire\HeatMap::class)->name('heat.map');

Route::get('/clustering-map', \App\Http\Livewire\ClusteringMap::class)->name('clustering.map');

Route::get('/dashboard', \App\Http\Livewire\Dashboard::class)->name('dashboard');