<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/members', [MemberController::class, 'index']);           
Route::get('/members/counts', [MemberController::class, 'countRoles']); 

Route::get('/', function () {
    return view('welcome');
});
