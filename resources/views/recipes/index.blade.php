@extends('layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <livewire:recipes-list :show-favorites="isset($is_favorite) ? $is_favorite : false"/>
    </main>
@endsection
