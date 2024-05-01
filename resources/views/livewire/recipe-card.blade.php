<div
    x-data="{ open: false }"
    class="card min-w-[305px] bg-green-500 shadow-xl image-full"
>
    <figure><img src="{{ asset('storage/'. $recipe->photo_url) }}" alt="Shoes" /></figure>
    <div class="card-body">
        <div class="card-title justify-between">
            <h2>{{ $recipe->title }}</h2>
            <a
                href="#"
                class="rounded-full p-2 border border-error"
                wire:click.throttling.1000ms.debounce.0ms.="toggle()"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    @if($recipe->favorites->contains('user_id', auth()->id()))
                        fill="currentColor"
                    @else
                        fill="none"
                    @endif
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-error"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"
                    />
                </svg>
            </a>
        </div>
        <p>{{ Str::limit($recipe->description, 30, '...') }}</p>
        <div class="card-actions justify-end">
            <button
                @click="open = !open"
                class="btn btn-accent btn-sm"
            >
                Ингредиенты
            </button>
            <div
                x-show="open"
                x-transition.debounce.750ms
                @click.away="open = false"
                class="absolute left-0 top-0 z-100 w-full mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
            >
                <div class="p-4">
                    <p class="text-sm text-gray-700 pb-1 border-b">
                        Ингредиенты
                    </p>
                    <p class="text-sm text-gray-700">
                        @foreach($recipe->ingredients as $ingredient)
                            {{ $ingredient->title }},
                        @endforeach
                    </p>
                </div>
                <div class="p-2 border-t border-gray-200">
                    <button
                        @click="open = false"
                        class="btn btn-sm btn-primary w-full z-22"
                    >
                        Закрыть
                    </button>
                </div>
            </div>
            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-secondary btn-sm">
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
                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"
                    />
                </svg>
                Подробнее
            </a>
        </div>
    </div>
</div>
