<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('members', MemberController::class);

Route::get('/members-counts', [MemberController::class, 'countRoles']);