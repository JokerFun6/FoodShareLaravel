<!DOCTYPE html>
<html lang="en" data-theme="light1">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-small.png') }}" type="image/png">
    @yield('styles')
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">
    <title>@yield('title')</title>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body>
<header class="w-full bg-primary">
    <nav class="mx-auto max-w-[1440px] border-b border-gray-200 dark:bg-dark-color-base-100" x-data="{ open: false, dropdownOpen: false }">
        <div class="max-w-screen mx-auto p-4 flex items-center justify-between">
            <div class="flex items-center justify-center">
                <a href="{{ route('recipes.topic') }}" class="flex items-center justify-center min-[940px]:mr-10 ">
                    <img src="{{ asset('assets/images/logo.png') }}" class="h-10 md:w-full" alt="Логотип">
                </a>
                <div class="hidden min-[940px]:flex space-x-8 rtl:space-x-reverse">
                    <a href="{{ route('recipes.create') }}" class="text-base-100 dark:text-dark-color-neutral hover:text-neutral dark:hover:text-dark-color-primary">Создать рецепт</a>
                    <a href="{{ route('recipes.index') }}" class="text-base-100 dark:text-dark-color-neutral hover:text-neutral  dark:hover:text-dark-color-primary">Все рецепты</a>
                    <a href="{{ route('recipes.random') }}" class="text-base-100 dark:text-dark-color-neutral hover:text-neutral  dark:hover:text-dark-color-primary">Случайный рецепт</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="hidden min-[940px]:block">
                    <livewire:search-form />
                </div>
                @auth
                    <button @click="dropdownOpen = !dropdownOpen" class="relative ml-2">
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
                    <x-mary-button label="Войти" link="{{ route('login') }}" class="btn btn-sm btn-accent md:ml-2" icon-right="o-power" />
                @endauth
            </div>
            <button @click="open = !open" class="min-[940px]:hidden order-first">
                <svg class="w-6 h-6 text-white dark:text-dark-color-neutral" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div x-cloak x-show="open" class="min-[940px]:hidden">
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
