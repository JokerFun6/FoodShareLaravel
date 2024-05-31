<div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3" x-data="{ showModal: false, recipeId: null }">
    @foreach($recipes as $recipe)
        <div class="col-span-1" wire:key="{{ $recipe->id }}">
            <div class="h-full shadow-lg hover:bg-neutral hover:border-white hover:transition-all rounded-lg p-4 flex flex-col justify-between">
                <div class="flex gap-1 flex-wrap flex-col justify-between items-start">
                    <h2 class="text-xl font-semibold">
                        <a href="{{ route('recipes.show', $recipe->slug_title) }}">
                            {{ $recipe->title }}
                        </a>
                    </h2>
                    @if($recipe->is_publish)
                        <div>Статус: <span class="badge badge-success border-sm badge-lg">Опубликован</span></div>
                    @else
                        <div>Статус: <span class="badge badge-info border-sm badge-lg">Неопубликован</span></div>
                    @endif
                </div>
                <div class="flex justify-between mt-4">
                    <button
                        class="btn btn-outline btn-error btn-sm"
                        @click="recipeId = {{ $recipe->id }};showModal = true">
                        <x-mary-icon name="o-trash" />
                        Удалить
                    </button>
                    <a href="{{ route('recipes.edit', $recipe->slug_title) }}" wire:navigate class="btn btn-outline btn-warning btn-sm">
                        <x-mary-icon name="o-pencil" />
                        Изменить
                    </a>
                </div>
            </div>
        </div>
    @endforeach
            <div x-cloak x-show="showModal"
                 class="fixed inset-0 flex items-center justify-center z-50">
                <div class="bg-black bg-opacity-50 fixed inset-0 backdrop-blur-sm"></div>
                <div class="bg-base-100 rounded-lg shadow-lg z-10 m-2 p-10" @click.outside="showModal=false">
                    <h2 class="text-xl mb-4">Вы уверены, что хотите удалить рецепт?</h2>
                    <div class="flex justify-end">
                        <button @click="showModal = false" class="btn btn-secondary btn-sm mr-3">Отмена</button>
                        <button @click="$wire.deleteRecipe(recipeId); showModal = false; $wire.$refresh()" class="btn btn-error btn-outline btn-sm">Удалить</button>
                    </div>
                </div>
            </div>
</div>
