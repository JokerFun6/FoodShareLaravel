<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\RecipeController;
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
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function (){
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::get('register', function (){
        return view('auth.register');
    })->name('register');
});

Route::middleware('auth')->group(function (){
    Route::get('logout', [LoginController::class, 'destroy'])->name('login.destroy');
    Route::get('users/profile', [UserController::class, 'index'])->name('users.index');
    Route::post('users/profile/update', [UserController::class, 'update'])->name('users.update');
    Route::post('recipes/{recipe}/comments/store', [CommentController::class, 'store'])->name('recipes.comments.store');
    Route::get('recipes/{recipe}/comments/{comment}/destroy', [CommentController::class, 'destroy'])->name('recipes.comments.destroy');

});

Route::get('users/profiles', [UserController::class, 'subscriber'])->name('users.subscriber');
Route::get('recipes/random', [RecipeController::class, 'random'])->name('recipes.random');
Route::get('recipes/topic', [RecipeController::class, 'topic'])->name('recipes.topic');
Route::resource('recipes', RecipeController::class);
Route::get('recipes/{recipe}/pdf-preview', [RecipeController::class, 'preview'])->name('recipes.preview');
