<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    @yield('styles')
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>@yield('title')</title>
</head>
<body>
<header class="bg-primary">
    <div class="navbar mx-auto justify-between max-w-[1440px]">
        <div class="navbar-start w-auto">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"
                        />
                    </svg>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm bg-primary dropdown-content mt-3 z-[21] p-2 shadow rounded-box w-52"
                >
                    <li><a>Создать рецепт</a></li>
                    <li><a>Категории</a></li>
                    <li><a>Фильтры</a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-center">
            <a href="{{ route('recipes.topic') }}" class="btn btn-ghost text-xl">
                <img src="{{ asset('assets/images/logo.svg') }}" class="md:w-1/3 w-20" alt="" />
            </a>
        </div>
        <div class="navbar-end w-auto">
            <div class="form-control">
                <input
                    type="search"
                    placeholder="Search"
                    class="input input-bordered input-sm w-full max-w-xs md:w-auto"
                />
            </div>
            @auth()
                <div class="dropdown dropdown-end">
                    <div
                        tabindex="0"
                        role="button"
                        class="btn btn-ghost btn-circle avatar"
                    >
                        <div class="w-10 rounded-full">
                            <img
                                alt="avatar"
                                src="{{ asset('storage/'. auth()->user()->avatar_url) }}"
                            />
                        </div>
                    </div>
                    <ul
                        tabindex="0"
                        class="mt-3 z-[55] p-2 bg-primary shadow menu menu-sm dropdown-content rounded-box w-52"
                    >
                        <li>
                            <a class="justify-between">
                                Profile
                                <span class="badge">New</span>
                            </a>
                        </li>
                        <li><a>Settings</a></li>
                        <li><a href="{{ route('login.destroy') }}">Выйти</a></li>
                    </ul>
                </div>
            @elseguest()
                <x-mary-button link="{{ route('login') }}"
                   icon="o-arrow-right-end-on-rectangle"
                   class="btn-circle btn-ghost ml-1"
                   tooltip-bottom="Вход"
                />
            @endauth

        </div>
    </div>
</header>
    @yield('content')
<x-mary-toast />
</body>
@livewireScripts
</html>
