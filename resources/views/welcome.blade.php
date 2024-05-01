@extends('layouts.base')
@section('title')
    Добро пожаловать!
@endsection

@section('content')
    <div class="hero min-h-screen" style="background-image: url({{ asset('assets/images/bg.jpeg') }})">
        <div class="hero-overlay bg-opacity-45"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-lg md:max p-3 border rounded-md bg-slate-700 bg-opacity-70">
                <h1 class="mb-5 text-4xl font-bold">Добро пожаловать</h1>
                <img src="{{ asset('assets/images/logo.png') }}" class="w-1/2 mx-auto" alt="logo">
                <p class="mb-5 text-lg">
                    Откройте для себя вкусный мир кулинарии на нашем сайте! Здесь вы найдете самые аппетитные рецепты, пошаговые инструкции и полезные советы от других пользователей. Присоединяйтесь к нам и создавайте кулинарные шедевры вместе с нами!
                </p>
                <a href="{{ route('recipes.topic') }}" class="btn btn-primary text-xl md:text-2xl">Исследовать рецепты</a>
            </div>
        </div>
    </div>
@endsection
