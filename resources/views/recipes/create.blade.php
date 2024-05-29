@extends('layouts.base')

@section('title')
    Страница добавления рецепта
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <livewire:recipe-create :recipe="null"/>
    </main>
@endsection
