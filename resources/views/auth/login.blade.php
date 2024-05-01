@extends('layouts.base')

@section('title')
    Страница авторизации
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <livewire:login-form />
    </main>
@endsection
