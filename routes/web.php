<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\user\UserController;
use App\Livewire\Welcome;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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


//Route::get('auth/vk', function (){
//    return Socialite::driver('vkontakte')->redirect();
//} )->name('auth');
//
//Route::get('auth/vk/callback', function (){
//    $user = Socialite::driver('vkontakte')->user();;
//    dd($user);
//} )->name('auth.callback');

Route::get('auth/yandex', function (){
    return Socialite::driver('yandex')->redirect();
} )->name('auth.yandex');

Route::get('auth/yandex/callback', function () {
    try {
        $yandexUser = Socialite::driver('yandex')->user();
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error fetching Yandex user: '.$e->getMessage());

        // Redirect to a custom error page or back with an error message
        return redirect()->route('login')->with('error', 'Unable to login using Yandex. Please try again.');
    }

    // Check if the user already exists
    $user = User::where('email', $yandexUser->email)->first();

    if (!$user) {
        // Create a new user if not exists
        $user = User::create([
            'login' => $yandexUser->user['login'],
            'name' => $yandexUser->user['first_name'],
            'lastname' => $yandexUser->user['last_name'],
            'is_verified' => true,
            'avatar_url' => User::generateAvatar($yandexUser->user['login']),
            'email' => $yandexUser->email,
            'password' => bcrypt(Str::random(10)), // Random password as it won't be used
        ]);
    }

    // Log the user in
    Auth::login($user, true); // True for remember me

    // Redirect to the intended page
    return redirect()->route('users.index');
})->name('auth.yandex.callback');



