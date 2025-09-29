<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', \App\Http\Livewire\Home::class)->name("Home");

Route::get('/data-maps', \App\Http\Livewire\DataMaps::class)->name('data.maps');