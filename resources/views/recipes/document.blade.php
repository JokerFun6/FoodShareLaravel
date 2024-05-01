<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 14px;
        }
    </style>

</head>
<body>
<div class="">
    <h1 >{{ $recipe->title }}</h1>
    <p >{{ $recipe->description }}</p>
    <br>
    {{--        Тут надо поменять url--}}
    <img src="{{ 'storage/' . $recipe->photo_url}}" width="500px" class="" alt="">
    <p class="">
        Время приготовления: {{ $recipe->preparation_time }} минут(ы)
    </p>
    <p class="">
        Сложность: {{ $recipe->complexity }}
    </p>
    <p class="">
        Количество порций: {{ $recipe->amount_services }}
    </p>
    <p class="">
        Оценка: {{ number_format($recipe->mark_avg, 2) }}
    </p>
    <p class="">
        Примерная стоимость: {{ $recipe->cost }} руб.
    </p>
    <p class="">
        Ингредиенты:
    </p>
    <ol class="">
        @foreach($recipe->ingredients as $ingredient)
            <li>
                {{ $ingredient->title }} ({{ $ingredient->pivot->value }} {{ $ingredient->pivot->measure }})
            </li>
        @endforeach
    </ol>
    <h2 class="">Пошаговое руководство</h2>
    <ol class="">
        @forelse($recipe->steps as $step)
            <li class="" style="list-style-type: none">
                <div class="">
                    <img src="{{ 'storage/'.$step->photo_url }} " class="" style="width: 50%; margin-right: auto " alt="Рецепт">
                </div>
                <div class="">
                    <p>
                        <span class="">{{ $loop->iteration }}.</span>
                        {{ $step->description }}
                    </p>

                </div>
            </li>
        @empty
            <h2>Шаги отсутствуют</h2>
        @endforelse
    </ol>
</div>
</body>
</html>
