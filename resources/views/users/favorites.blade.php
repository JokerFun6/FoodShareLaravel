@extends('layouts.base')

@section('title')
    Избранные рецепты
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <livewire:user-list :recipes="$recipes"/>
    </main>
@endsection
