<div>
    @php
        $config = [
            'guides' => false,
            'initialAspectRatio' => 1,
            'minCropBoxHeight' => 256,
            'minCropBoxWidth' => 256,
            'minContainerWidth' => 100,
            'minContainerHeight' => 100,
            'cropBoxResizable' => false
       ];
    @endphp
    <h2 class="text-xl text-center mb-3">
        Личная информация
    </h2>
    <div class="flex flex-col justify-around items-stretch">
        <x-mary-file c change-text="Изменить" wire:model="avatar" class="mx-auto mb-3" crop-title-text="Редактирование" crop-cancel-text="Отменить" crop-save-text="Сохранить" :crop-config="$config" crop-after-change>
            <img src="{{ asset('storage/'. auth()->user()->avatar_url) }}" class="w-1/2 md:w-2/3 mx-auto mask mask-circle" alt="avatar">
        </x-mary-file>
        <x-mary-input label="Почта" value="{{ auth()->user()->email }}" class="input-info input-md mb-3" inline readonly/>
        <x-mary-input label="Логин" value="{{ auth()->user()->login }}" class="input-info input-md mb-3" inline readonly/>
        <x-mary-input label="Имя" wire:model="name"  class="input-info input-md mb-3" inline />
        <x-mary-input label="Фамилия" wire:model="last_name"  class="input-info input-md mb-3" inline />
        <x-mary-choices-offline
            wire:model="selectedIngredients"
            :options="$ingredients"
            option-label="title"
            label="Выберите нелюбимые ингредиенты"
            class="input-info mb-4"
            searchable
            no-result-text="ничего не нашли"
        />
        <button type="button" class="btn btn-outline btn-info btn-sm w-1/2 mx-auto" wire:click="save">Сохранить</button>

    </div>


</div>
