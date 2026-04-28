<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::livewire('/', 'pages::dashboard.dashboard-index')->name('home');
    Route::livewire('/profile', 'pages::auth.profile')->name('profile');

    // PRODUK
    Route::livewire('/produk', 'pages::produk.produk-index')->name('produk');
    Route::livewire('/produk/list', 'pages::produk.produk-list')->name('produk.list');

});

Route::middleware(['guest'])->group(function () {
    Route::livewire('/login', 'pages::auth.login')->name('login');
});
