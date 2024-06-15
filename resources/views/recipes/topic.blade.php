@extends('layouts.base')

@section('styles')
{{--    <link--}}
{{--        rel="stylesheet"--}}
{{--        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"--}}
{{--    />--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>--}}
@endsection

@section('title')
    Главная страница
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <header class="mb-8 p-6 bg-primary text-white rounded-lg shadow-lg">
            <div class="flex flex-wrap items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/images/logo-small.png') }}" alt="Site Logo" class="h-16 w-16 object-cover rounded-full">
                    <h1 class="text-3xl font-bold text-base-100">FoodShare</h1>
                </div>
                <!-- Info -->
                <p class="max-w-lg text-base-100 text-lg">Добро пожаловать на наш сайт, где вы найдете множество вкусных и разнообразных рецептов! Исследуйте популярные и последние опубликованные рецепты ниже.</p>
            </div>
        </header>
        <div class="swiper">
            <h2 class="text-2xl text-neutral-content mb-3">Популярные рецепты</h2>
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach($popular as $recipe)
                <div class="swiper-slide" data-swiper-autoplay="3000">
                    <livewire:recipe-card :recipe="$recipe"/>
                    <div class="swiper-lazy-preloader"></div>
                </div>
                @endforeach
                ...
            </div>
            <!-- If we need pagination -->


            <!-- If we need navigation buttons -->
{{--            <div class="swiper-button-prev"></div>--}}
{{--            <div class="swiper-button-next"></div>--}}

            <!-- If we need scrollbar -->

        </div>
        <div class="swiper mt-3 z-[0]">
            <h2 class="text-2xl text-neutral-content mb-3">Последние опубликованные рецепты</h2>
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper px-3">
                <!-- Slides -->
                @foreach($latest as $recipe)
                    <div class="swiper-slide" data-swiper-autoplay="3000">
                        <livewire:recipe-card :recipe="$recipe"/>
                    </div>
                @endforeach

                ...
            </div>

            <!-- If we need navigation buttons -->
{{--            <div class="swiper-button-prev"></div>--}}
{{--            <div class="swiper-button-next"></div>--}}

            <!-- If we need scrollbar -->

        </div>
    </main>


@endsection
