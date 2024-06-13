<section
    class="rounded-lg shadow-lg mt-4 py-8 lg:py-16 antialiased"
>
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2
                class="text-lg lg:text-2xl font-bold"
            >
                Комментарии ({{ $recipe->comments()->count() }})
            </h2>
        </div>
        @auth
        <form class="mb-6" wire:submit.prevent="addComment">

            <div
                class="py-2 px-4 mb-4 bg-base-100 rounded-lg rounded-t-lg border border-gray-200"
            >
                <label for="comment" class="sr-only">Твой комментарий</label>
                <textarea
                    id="comment"
                    rows="6"
                    class="px-0 w-full bg-base-100 text-sm border-0 focus:ring-0 focus:outline-none"
                    placeholder="Оставьте комментарий"
                    required
                    wire:model="text"
                ></textarea>
                @error('text')
                    <span class="text-error mb-3 mt-3">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
            <div>
                @if (!$photo)
                <input type="file"
                       class="file-input file-input-bordered file-input-sm w-full max-w-xs mb-1"
                       wire:model="photo"
                       accept="image/png, image/jpeg, image/jpg"
                />
                <div class="label mb-2" >
                    <span class="label-text-alt">Можете загрузить файл</span>
                </div>

                @endif
                <div wire:loading.class.remove="hidden" wire:target="photo" class="hidden">
                    <x-mary-loading class="loading-infinity loading-lg block mx-auto" />
                </div>
                @if ($photo)
                    <div class="flex justify-start">
                        <img wire:target="photo" src="{{ $photo->temporaryUrl() }}" class="w-[100px] mb-3 mr-3 rounded-box">
                        <x-mary-button class="text-error" wire:click="clearPhoto" icon-right="o-x-circle" />
                    </div>
                    @error('photo')
                        <span class="text-error mb-3 mt-3">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                @endif
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="photo"
                class="btn btn-outline btn-secondary btn-sm"
            >
                Отправить
            </button>
        </form>
        @elseguest()
            <div class="text-center text-info mb-7 text-xl">Войдите в систему, чтобы оставить комментарий</div>
        @endauth
        @forelse($comments as $comment)
            <article wire:key="{{ $comment->id }}" class="p-6 text-base mb-5 rounded-lg shadow-xl shadow-neutral">
            <footer class="flex justify-between items-center mb-2">
                <div class="flex items-center flex-wrap">
                    <a
                        class="inline-flex items-center mr-3 text-sm font-semibold"
                        href="{{ route('users.index', $comment->user?->id) }}"
                    >
                        <img
                            class="mr-2 w-6 h-6 rounded-full"
                            src="{{ asset('storage/' . $comment->user?->avatar_url) }}"
                            alt="{{ $comment->user?->login }}"
                        />{{ $comment->user?->login }}
                    </a>
                    <p class="text-sm mr-2">
                        <time pubdate datetime="{{ $comment->created_at }}" title="February 8th, 2022"
                        >{{ $comment->created_at->diffForHumans() }}</time
                        >
                    </p>
                        @if($comment->user?->login === auth()->user()?->login)
                            <button href="" class="text-sm text-error" wire:confirm="Вы действительно хотите удалить комментарий?" wire:click="removeComment({{ $comment->id }})">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                    />
                                </svg>
                            </button>
                        @endif
                </div>
            </footer>
            <p class="mb-3">
                {{ $comment->description }}
            </p>
                <img src="{{ asset('storage/'.$comment->photo_url) }}" class="w-[250px] rounded-box" alt="">
            <div class="flex items-center mt-4 space-x-4">

            </div>
        </article>
        @empty
            <p class="text-center text-info text-xl">Список комментариев пока пуст, станьте первым🥇</p>
        @endforelse
    </div>
</section>
