<div class="min-h-screen flex flex-col">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <select
                class="select select-ghost border border-white select-sm w-full mb-3 focus:ring-0 focus:border-none active:ring-0 active:border-none max-w-xs"
                wire:model.live="sortBy"
            >
                <option disabled selected>Упорядочить по</option>
                <option value="created_at">Дате публикации</option>
                <option value="title">По названию</option>
                <option value="cost">По цене</option>
            </select>

            <div class="ml-3 self-start">
                @if($sortDirection == 'desc')
                    <button wire:click="changeDirection">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                @else
                    <button wire:click="changeDirection">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                @endif


            </div>
            <span wire:loading class="hidden loading loading-lg self-center loading-spinner text-accent"></span>
        </div>

        <div x-data="{ open: false }" class="relative self-start">
            <x-mary-button @click="open = !open" class="btn btn-accent btn-sm" icon-right="o-funnel">
                <span class="hidden sm:inline">Фильтры</span>
            </x-mary-button>

            <div x-cloak x-show="open" class="fixed inset-0 z-50 flex">
                <!-- Overlay -->
                <div @click="open = false" class="fixed inset-0 bg-base-100 bg-opacity-50 backdrop-blur-sm"></div>

                <!-- Sidebar -->
                <div class="relative w-80 overflow-y-auto bg-neutral shadow-lg transform transition-all duration-300 ease-in-out scrollbar-thumb-rounded-[15px] scrollbar-track-rounded-full scrollbar-thin scrollbar-thumb-primary scrollbar-track-base-100 overflow-y-auto overflow-x-hidden"
                     :class="{ 'translate-x-0': open, '-translate-x-full': !open }">
                    <div class="p-6 ">
                        <!-- Close Button -->
                        <button @click="open = false" class="absolute w-8 top-4 right-4 text-primary">
                            &times;
                        </button>
                        <h2 class="text-xl font-bold mb-3 border-b-2 border-white">Фильтры</h2>
                        <form action="" class="overflow-y-auto" method="get">
                            <label class="block mb-4">
                                <span class="label">Выберите сложность:</span>
                                <select wire:model.live="level"
                                        class="select border-base-100 bg-base-100 select-sm w-full active:ring-0 active:border-none">
                                    <option value="" selected>Выберите уровень</option>
                                    <option value="легкий">легкий</option>
                                    <option value="средний">средний</option>
                                    <option value="сложный">сложный</option>
                                </select>
                            </label>

                            <div class="form-control mb-4">
                                <label class="block mb-2">Укажите диапазон цен</label>
                                <div class="flex items-center">
                                    <x-mary-input
                                        type="number"
                                        min="0"
                                        label="мин"
                                        wire:model.live.debounce.250ms="min_price"
                                        class="input-sm border border-black p-2"
                                    />
                                    <span class="mx-2">-</span>
                                    <x-mary-input
                                        type="number"
                                        min="0"
                                        label="макс"
                                        wire:model.live.debounce.250ms="max_price"
                                        class="input-sm border border-black p-2"
                                    />
                                </div>
                            </div>
                            <hr class="my-4"/>
                            <div class="form-control mb-4">
                                <label class="block mb-2">Укажите диапазон времени приготовления</label>
                                <div class="flex items-center">
                                    <x-mary-input
                                        type="number"
                                        min="0"
                                        label="мин"
                                        wire:model.live.debounce.250ms="min_time"
                                        class="input-sm border border-black p-2"
                                    />
                                    <span class="mx-2">-</span>
                                    <x-mary-input
                                        type="number"
                                        min="0"
                                        label="макс"
                                        wire:model.live.debounce.250ms="max_time"
                                        class="input-sm border border-black p-2"
                                    />
                                </div>
                            </div>
                            @auth
                                <label class="block mb-4">
                                    <x-mary-checkbox class="checkbox-primary" label="Исключить нелюбимые продукты"
                                                     wire:model.live="is_allergy"/>
                                </label>
                                <label class="block mb-4">
                                    <x-mary-checkbox class="checkbox-primary" label="Включить избранное" wire:model.live="showFavorites"/>
                                </label>
                            @endauth
                            <hr class="my-4"/>
                            <x-mary-choices-offline
                                wire:model.live="selectedTags"
                                :options="$this->tags"
                                option-label="title"
                                label="Выберите желаемые категории"
                                class="border-none mb-2"
                                icon="o-hashtag"
                                searchable
                                no-result-text="ничего не нашли"
                            />
                            <hr class="my-4"/>
                            <x-mary-choices-offline
                                wire:model.live="selectedIngredients"
                                :options="$this->ingredients"
                                option-label="title"
                                label="Выберите необходимые ингредиенты"
                                class="border-none mb-4"
                                icon="o-beaker"
                                searchable
                                no-result-text="ничего не нашли"
                            />
                            <button type="button" wire:click="resetProperties"
                                    class="btn btn-sm btn-outline btn-error w-full">Сбросить все</button>
                            <span wire:loading.class.remove="hidden"
                                  class="hidden loading loading-spinner loading-lg mx-auto mt-4"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="cards grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-between items-stretch mb-5"
    >
        @forelse($recipes as $recipe)
            <livewire:recipe-card :key="$recipe->id" :recipe="$recipe" />
        @empty
               <h1 class="text-xl text-center col-span-full">Не удалось ничего найти</h1>
        @endforelse
    </div>

    <div class="mt-auto ">
        {{ $recipes->links() }}
    </div>


</div>
