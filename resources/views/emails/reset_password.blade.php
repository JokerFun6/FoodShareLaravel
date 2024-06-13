@extends('layouts.email')

@section('content')
    <div class="flex p-2 gap-3 items-center">
        <h2 class="text-lg">Ваш новый пароль от сервиса FoodShare: </h2>
        <div class="bg-primary p-4 rounded-box shadow-xl">{{ $new_password }}</div>
    </div>

@endsection
