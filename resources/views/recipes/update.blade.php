@extends('layouts.base')

@section('title')
    Страница редактирования рецепта
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <livewire:recipe-create :recipe="$recipe"/>
    </main>
@endsection
