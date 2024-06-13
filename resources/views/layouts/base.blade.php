<!DOCTYPE html>
<html lang="en" data-theme="light">
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
    <nav class="mx-auto max-w-[1440px]" x-data="{ open: false, dropdownOpen: false }">
        <div class="max-w-screen mx-auto p-4 flex items-center justify-between">
            <div class="flex items-center justify-center">
                <a x-data="{darkMode: $persist(false)}" @mode.window="darkMode = $event.detail" href="{{ route('recipes.topic') }}" class="flex items-center justify-center min-[940px]:mr-10 ">
                    <img :src="darkMode === 'dark' ? '{{ asset('assets/images/logo-dark.png') }}' : '{{ asset('assets/images/logo.png') }}'"
                         class="h-10 md:w-full"
                         x-init="$watch('darkMode', value => console.log(value))"

                         alt="Логотип">
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
                        <div x-cloak x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-base-100 rounded-md shadow-lg py-2 z-20 ">
                            <div x-data="{ darkMode: $persist(false) }">
                                <label class="flex justify-center cursor-pointer gap-2 p-2 mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="5"/>
                                        <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/>
                                    </svg>
                                    <input type="checkbox"
                                           :value="darkMode ? 'dark' : ''"
                                           @change="darkMode = $event.target.checked ? 'dark' : ''; $dispatch('mode', darkMode);"
                                           :checked="darkMode === 'dark'"
                                           class="toggle toggle-accent theme-controller"/>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                                    </svg>
                                </label>
                            </div>
                            <a href="{{ route('users.index') }}" class="block px-4 py-2 hover:bg-gray-100">Профиль</a>
                            <a href="{{ route('users.favorites') }}" class="block px-4 py-2 hover:bg-gray-100 ">
                                Избранное
                                <div class="badge badge-primary badge-outline badge-lg">{{ auth()->user()->favorites->count() }}</div>
                            </a>
                            <a href="{{ route('login.destroy') }}" class="block px-4 py-2 hover:bg-gray-100">Выход</a>
                        </div>
                    </button>
                @elseguest
                    <x-mary-button label="Войти" link="{{ route('login') }}" class="btn btn-sm btn-accent md:ml-2" icon-right="o-power" />
                @endauth
            </div>
            <button @click="open = !open" class="min-[940px]:hidden order-first">
                <svg class="w-6 h-6 text-base-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div x-cloak x-show="open" class="min-[940px]:hidden">
            <a href="{{ route('recipes.create') }}" class="text-base-100 block px-4 py-2 hover:text-neutral ">Создать рецепт</a>
            <a href="{{ route('recipes.index') }}" class="text-base-100 block px-4 py-2 hover:text-neutral ">Все рецепты</a>
            <a href="{{ route('recipes.random') }}" class="text-base-100 block px-4 py-2 hover:text-neutral ">Случайный рецепт</a>
            <div class="w-full px-4 mb-3">
                <livewire:search-form />
            </div>
        </div>
    </nav>
</header>
    @yield('content')
<footer class="footer flex items-center justify-between p-2 border-t-2 text-neutral-content">
    <aside class="items-center grid-flow-col">
        <img src="{{ asset('assets/images/logo-small.png') }}" width="34px" alt="logo">
        <p>Copyright © 2024 - All right reserved</p>
    </aside>
    <nav class="flex justify-end self-end">
        @guest
        <div x-data="{ darkMode: $persist(false) }">
            <label class="swap swap-rotate">
                <!-- this hidden checkbox controls the state -->
                <input type="checkbox"
                       x-model="darkMode"
                       @change="darkMode = $event.target.checked ? 'dark' : ''; $dispatch('mode', darkMode);"
                       x-bind:checked="darkMode === 'dark'"
                       class="theme-controller" value="dark" />

                <!-- sun icon -->
                <svg class="swap-off fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/>
                </svg>

                <!-- moon icon -->
                <svg class="swap-on fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/>
                </svg>
            </label>
        </div>
        @endguest
    </nav>
</footer>
<x-mary-toast />
</body>
@livewireScripts
</html>
