@extends('layouts.base')

@section('title')

@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <!-- Секция с информацией -->
        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 mb-5">
            <h1 class="text-3xl col-span-1 md:col-span-2 text-center mb-4">
                {{ $recipe->title }}
            </h1>
            <div class="">
                <img
                    src="{{ asset('storage/'. $recipe->photo_url) }}"
                    class="rounded-lg border-primary border-2 mb-3 hover:shadow-xl hover:shadow-accent"
                    alt=""
                />
{{--                rating--}}
                <livewire:rating-form :recipe="$recipe"/>
            </div>

            <div class="information">
                <ul class="menu bg-neutral border border-white rounded-box mb-3">
                    <li class="menu-title text-accent-content text-xl">
                        Список Ингредиентов
                    </li>
                    @foreach($recipe->ingredients as $ingredient)
                        <li><a>{{ $loop->iteration }}. {{ $ingredient->title }}
                                {{ $ingredient->pivot->value }}
                                {{ $ingredient->pivot->measure }}
                                ({{ $ingredient->pivot->comment }})</a></li>
                    @endforeach

                </ul>

                <ul class="p-4 bg-accent rounded-box">
                    <li>
                        <span class="font-black">Описание:</span>
                        {{ $recipe->description }}
                    </li>

                    <li>
                        <span class="font-black">Количество порций:</span>
                        {{ $recipe->amount_services }}
                    </li>

                    <li>
                        <span class="font-black">Время приготовления:</span>
                        {{ $recipe->preparation_time }} минут
                    </li>
                    <li>
                        <span class="font-black">Сложность:</span>
                        <a href="" class="badge badge-success">{{ $recipe->complexity }}</a>
                    </li>
                    <li class="mb-5">
                        <span class="font-black">Примерная стоимость: </span>
                        {{ $recipe->cost }} рублей
                    </li>
                    <hr />
                    <li class="my-5">
                        <span class="font-black">Опубликовано: </span>
                        {{ $recipe->created_at->format('d.m.Y г.') }}
                    </li>
                    <li class="mb-5 flex items-center">
                        <span class="font-black mr-2">Автор: </span>
                        <a href="#" class="link link-hover">{{ $recipe->user->login }}</a>
                        <a href="#">
                            <div class="avatar ml-2">
                                <div
                                    class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2"
                                >
                                    <img
                                        src="{{ asset('storage/'. $recipe->user?->avatar_url) }}"
                                        alt="Аватар пользователя"
                                    />
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="my-3">
                        <livewire:favorite-button :recipe="$recipe" />
                        <a class="btn bg-slate-600 btn-outline btn-sm" href="{{ route('recipes.preview', $recipe) }}">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                                />
                            </svg>

                            Скачать
                        </a  >
                    </li>
                </ul>
            </div>
        </div>

        <!-- Секция с шагами -->
        <div
            class="instructions grid grid-cols-1 md:grid-cols-2 gap-3 bg-accent p-7 rounded-box shadow-lg"
        >
            <h1 class="text-3xl col-span-1 md:col-span-2 text-center mb-4">
                Пошаговая инструкция
            </h1>
            @foreach($recipe->steps as $step)
                <div
                    class="step bg-violet-600 border max-w-[1000px] border-white p-7 rounded-box grid grid-cols-1 lg:grid-cols-2 md:col-span-1 gap-3 justify-center items-start shadow hover:shadow-white"
                >
                    @if($step->photo_url)
                        <div class="max-w-[450px] self-center justify-self-center">
                            <img
                                src="{{ asset('storage/' . $step->photo_url) }}"
                                class="border border-white rounded-box"
                                alt="Изображение отсутствует"
                            />
                        </div>
                    @endif
                    <p>
                        <span class="font-black ">Шаг {{ $loop->iteration }}. </span>
                        {{ $step->description }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Секция с видео -->
{{--        <div class="video bg-base-200 rounded-box p-5 mt-5">--}}
{{--            <h2 class="text-2xl text-center mb-3">Видеоинструкция</h2>--}}
{{--            <div--}}
{{--                class="w-full mx-auto aspect-w-16 aspect-h-9 relative"--}}
{{--                style="padding-top: 42.857143%"--}}
{{--            >--}}
{{--                <iframe--}}
{{--                    class="embed-responsive-item absolute bottom-0 left-0 right-0 top-0 h-full w-full"--}}
{{--                    src="https://www.youtube.com/embed/vlDzYIIOYmM"--}}
{{--                    allowfullscreen=""--}}
{{--                    data-gtm-yt-inspected-2340190_699="true"--}}
{{--                    id="240632615"--}}
{{--                ></iframe>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Секция с комментариями -->
        <livewire:comment-section :recipe="$recipe" />
    </main>
@endsection
