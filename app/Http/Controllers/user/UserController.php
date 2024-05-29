<?php

namespace App\Http\Controllers\user;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
        public function index($id = null)
    {
        if (Auth::check() && ($id == Auth::user()->id || $id === null)) {
            // Пользователь авторизован, показываем его профиль
            $user = Auth::user();
            $recipes = auth()->user()->recipes;
            $subcriptions = $user->subscriptions;
            return view('users.profile', compact('recipes', 'subcriptions'));
        }
        elseif ($id) {
            // Проверка переданного ID пользователя
            $user = User::find($id);

            if (!$user) {
                // Если пользователь не найден, вернем 404 ошибку
                abort(404, 'Пользователь не найден');
            }
            return view('users.subscriber', compact('user', 'id'));
        } else {
            // Если не авторизован и ID не указан, перенаправляем на страницу логина
            return redirect()->route('login');
        }

    }

    public function favorites(){
       return view('recipes.index', ['is_favorite' => true, 'title' => 'Все рецепты']);
    }

}
