<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\user\UserController;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function (){
    session()->forget(['user_id', 'verify_code']);
    return redirect()->route('recipes.topic');
})->name('welcome');

Route::middleware('guest')->group(function (){
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::get('register', function (){
        return view('auth.register');
    })->name('register');
});

Route::middleware('auth')->group(function (){
    Route::get('logout', [LoginController::class, 'destroy'])->name('login.destroy');
    Route::get('users/favorites', [UserController::class, 'favorites'])->name('users.favorites');
});

Route::get('users/profile/{id?}', [UserController::class, 'index'])->name('users.index');
Route::get('recipes/random', [RecipeController::class, 'random'])->name('recipes.random');
Route::get('recipes/topic', [RecipeController::class, 'topic'])->name('recipes.topic');
Route::resource('recipes', RecipeController::class);
Route::get('recipes/{recipe}/pdf-preview', [RecipeController::class, 'preview'])->name('recipes.preview');


Route::get('/verify-email/', function (){

    if(session()->exists(['user_id', 'verify_code'])){
        return view('emails.verify');
    }
    abort(404);
})->name('verification.notice')->middleware('guest');




