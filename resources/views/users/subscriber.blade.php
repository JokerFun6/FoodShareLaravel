@extends('layouts.base')

@section('title')
    Личный кабинет пользователя
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <div class="flex flex-col md:flex-row items-center md:items-stretch">
            <div class="flex justify-center md:w-1/2 mb-6 md:mb-0 self-center">
                <img src="{{ asset('storage/' . $user->avatar_url) ?? 'default-avatar.png' }}" alt="{{ $user->name }}" class="rounded-full w-1/2 mask mask-circle object-cover mx-auto md:mx-0">
            </div>
            <div class="md:w-3/4 md:pl-8 flex flex-col justify-between">
                <div>
                    <h1 class="text-xl md:text-3xl mb-4 text-center font-bold">{{ $user->login }}</h1>
                    @if ($user->name || $user->lastname)
                        <p class="">Имя: {{ $user->name }}</p>
                        <p class="">Фамилия: {{ $user->lastname ?? 'не указан' }}</p>
                    @endif
                </div>

                <div class="mt-4">
                    <div class="grid grid-cols-1 min-[500px]:grid-cols-3 gap-4">

                        <div class="flex items-center p-1 bg-white cursor-pointer hover:scale-105 hover:shadow-lg transition-all border border-gray-200 rounded-lg shadow-sm">
                            <div class="ml-4">
                                <div class="text-sm sm:text-lg font-medium text-secondary">Подписчики</div>
                                <div class="text-2xl font-bold text-primary">{{ $user->subscribedTo()->count() }}</div>
                                <div class="text-sm text-secondary/100">Количество подписчиков</div>
                            </div>
                        </div>

                        <div class="flex items-center p-1 bg-white cursor-pointer hover:scale-105 hover:shadow-lg transition-all border border-gray-200 rounded-lg shadow-sm">
                            <div class="ml-4">
                                <div class="text-sm sm:text-lg font-medium text-secondary">Подписки</div>
                                <div class="text-2xl font-bold text-primary">{{ $user->subscriptions()->count() }}</div>
                                <div class="text-sm text-secondary/100">Количество подписок</div>
                            </div>
                        </div>

                        <div class="flex items-center p-1 bg-white cursor-pointer hover:scale-105 hover:shadow-lg transition-all border border-gray-200 rounded-lg shadow-sm">
                            <div class="ml-4">
                                <div class="text-sm sm:text-lg font-medium text-secondary">Рецепты</div>
                                <div class="text-2xl font-bold text-primary">{{ $user->recipes()->count() }}</div>
                                <div class="text-sm text-secondary/100">Количество рецептов на сайте</div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="mt-4 self-center">
                    <livewire:user-subscription-btn :userId="$id" />
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Рецепты пользователя</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
{{--                @foreach ($user->recipes->where('is_publish', true) as $recipe)--}}
                @forelse($user->recipes as $recipe)
                    <livewire:recipe-card :recipe="$recipe" />
                @empty
                    Пользователь пока не публиковал рецепты
                @endforelse
            </div>
        </div>
    </main>
@endsection
