<?php

use App\Http\Middleware\EnsureNameCookie;
use App\Livewire\Landing\LandingPage;
use App\Livewire\List\ListPage;
use App\Livewire\Name\NamePage;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureNameCookie::class)->group(function () {

    Route::get('/', LandingPage::class)->name('landing.page');
    Route::get('/name', NamePage::class)->name('name.page');

    Route::get('/list/{slug}/{password}', ListPage::class)->name('list.page');

});
