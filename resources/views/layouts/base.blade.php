<!DOCTYPE html>
<html lang="en" data-theme="light1">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-small.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    @yield('styles')

    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>@yield('title')</title>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body>
<header class="bg-primary hidden ">
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
                    class="menu menu-sm bg-primary dropdown-content mt-3 z-[21] p-2 border border-accent shadow rounded-box w-52"
                >
                    <li><a href="{{ route('recipes.create') }}">Создать рецепт</a></li>
                    <li><a>Категории</a></li>
                    <li><a href="{{ route('recipes.index') }}">Все рецепты</a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-center hidden min-[390px]:block">
            <a href="{{ route('recipes.topic') }}" class="btn btn-ghost text-xl">
                <img src="{{ asset('assets/images/logo.svg') }}" class="md:w-1/3 w-20" alt="" />
            </a>
        </div>
        <div class="navbar-end w-auto">
            <livewire:search-form />
            @auth
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
                            <a href="{{ route('users.index') }}" class="justify-between">
                                Профиль
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
<header class="w-full bg-primary">
    <nav class="mx-auto max-w-[1440px] border-b border-gray-200 dark:bg-dark-color-base-100" x-data="{ open: false, dropdownOpen: false }">
        <div class="max-w-screen mx-auto p-4 flex items-center justify-between">
            <div class="flex items-center justify-center space-x-4 rtl:space-x-reverse">
                <a href="{{ route('recipes.topic') }}" class="flex items-center justify-center md:mr-10 rtl:space-x-reverse">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-10 md:w-full" alt="Логотип">
                </a>
                <div class="hidden md:flex space-x-8 rtl:space-x-reverse">
                    <a href="{{ route('recipes.create') }}" class="text-base-100 dark:text-dark-color-neutral hover:text-neutral dark:hover:text-dark-color-primary">Создать рецепт</a>
                    <a href="{{ route('recipes.index') }}" class="text-base-100 dark:text-dark-color-neutral hover:text-neutral  dark:hover:text-dark-color-primary">Все рецепты</a>
                    <a href="{{ route('recipes.random') }}" class="text-base-100 dark:text-dark-color-neutral hover:text-neutral  dark:hover:text-dark-color-primary">Случайный рецепт</a>
                </div>
            </div>
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <div class="hidden md:block">
                    <livewire:search-form />
                </div>
                @auth
                    <button @click="dropdownOpen = !dropdownOpen" class="relative">
                        <img
                            class="w-10 mask mask-circle"
                            alt="avatar"
                            src="{{ asset('storage/'. auth()->user()->avatar_url) }}"
                        />
                        <div x-cloak x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 dark:bg-dark-color-neutral">
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-dark-color-neutral dark:hover:bg-dark-color-accent">Профиль</a>
                            <a href="{{ route('users.favorites') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-dark-color-neutral dark:hover:bg-dark-color-accent">
                                Избранное
                                <div class="badge badge-primary badge-outline badge-lg">{{ auth()->user()->favorites->count() }}</div>
                            </a>
                            <a href="{{ route('login.destroy') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-dark-color-neutral dark:hover:bg-dark-color-accent">Выход</a>
                        </div>
                    </button>
                @elseguest
                    <x-mary-button label="Войти" link="{{ route('login') }}" class="btn btn-sm btn-accent" icon-right="o-power" />
                @endauth
            </div>
            <button @click="open = !open" class="md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-dark-color-neutral order-first">
                <svg class="w-6 h-6 text-gray-700 dark:text-dark-color-neutral" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div x-cloak x-show="open" class="md:hidden">
            <a href="{{ route('recipes.create') }}" class="text-base-100 block px-4 py-2 dark:text-dark-color-neutral hover:text-neutral dark:hover:bg-dark-color-accent">Создать рецепт</a>
            <a href="{{ route('recipes.index') }}" class="text-base-100 block px-4 py-2 dark:text-dark-color-neutral hover:text-neutral dark:hover:bg-dark-color-accent">Все рецепты</a>
            <a href="{{ route('recipes.random') }}" class="text-base-100 block px-4 py-2 dark:text-dark-color-neutral hover:text-neutral dark:hover:bg-dark-color-accent">Случайный рецепт</a>
            <div class="w-full px-4 mb-3">
                <livewire:search-form />
            </div>
        </div>
    </nav>

</header>
    @yield('content')
<x-mary-toast />
</body>
@livewireScripts
</html>
