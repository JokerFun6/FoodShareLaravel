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

    </div>

    <div
        class="cards grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-between items-stretch mb-5"
    >
        @forelse($recipes as $recipe)
            <livewire:recipe-card :key="$recipe->id" :recipe="$recipe"/>
        @empty
            <h1 class="text-xl text-center col-span-full">Не удалось ничего найти</h1>
        @endforelse
    </div>



</div>
