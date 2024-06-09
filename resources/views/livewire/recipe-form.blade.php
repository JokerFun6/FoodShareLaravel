<div class="flex flex-col items-center justify-center mx-auto">

    <ul class="steps mx-auto mb-4 overflow-x-auto">
        <li class="step @if($stage >= 1) step-primary @endif" wire:click="setStage(1)">
            <span class="text-sm">Рецепт</span>
        </li>
        <li class="step @if($stage >= 2) step-primary @endif" wire:click="setStage(2)">
            <span class="text-sm">Ингредиенты</span>
        </li>
        <li class="step @if($stage >= 3) step-primary @endif" wire:click="setStage(3)">
            <span class="text-sm">Шаги</span>
        </li>
        <li class="step @if($stage >= 4) step-primary @endif" wire:click="setStage(4)" data-content="✔">
            <span class="text-sm">Готово</span>
        </li>
    </ul>

    @if($stage === 1)
        <form class="flex flex-col gap-3 p-3 lg:w-1/2 mx-auto border border-white rounded-box" action="" method="get">
            <h1 class="text-center text-xl mb-5">Добавьте ваш рецепт</h1>
            <x-mary-input
                wire:model="recipe_form.recipe_title"
                label="Напишите название рецепта"
                class="input-sm"
                hint="Минимум 5 символов" />

            <x-mary-textarea
                label="Описание рецепта"
                class=""
                wire:model="recipe_form.recipe_description"
                placeholder="Этот рецепт ..."
                hint="Минимум 20 символов"
                rows="5"
            />
            <label class="form-control w-full max-w-xs mb-3">
                <div class="label">
                    <span class="label-text">Добавьте изображение(необязательно)</span>
                </div>
                <input wire:model="recipe_form.recipe_photo" type="file" class="file-input file-input-bordered file-input-primary file-input-sm w-full max-w-xs" />
                <div wire:loading.class.remove="hidden" wire:target="recipe_photo" class="hidden">
                    <x-mary-loading class="loading-infinity loading-lg block mx-auto" />
                </div>
                @if ($this->recipe_form->recipe_photo)
                        <div  class="flex justify-start mt-3">
                            <img wire:target="photo"
                                 src="{{ $this->recipe_form->recipe_photo->temporaryUrl() }}"
                                 class="w-[200px] mb-3 mr-3 rounded-box">
                            <x-mary-button class="text-error" wire:click="clearPhoto" icon-right="o-x-circle" />
                        </div>
                    @error('recipe_form.recipe_photo')
                    <span class="text-red-500 label-text-alt mb-3 mt-3">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                @endif
            </label>
            @if ($this->recipe_form->photo_url && !$this->recipe_form->recipe_photo)
                <div  class="flex justify-center mt-3">
                    <img
                         src="{{ asset($this->recipe_form->photo_url) }}"
                         class="w-[250px] mb-3 mr-3 rounded-box">
                </div>
            @endif
            <x-mary-input type="number"
                class="input-sm"
                min="1"
                label="Время приготовления"
                wire:model="recipe_form.preparation_time"
                suffix="Минут" />
            <x-mary-input
                type="number"
                class="input-sm"
                min="1"
                label="Количество порций"
                wire:model="recipe_form.amount_services"
                suffix="Порций" />
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Выберите уровень сложности</span>
                </div>
                <select  wire:model="recipe_form.recipe_level" class="select select-sm select-primary w-full select-bordered">
                    <option selected value="">Уровень:</option>
                    <option value="легкий">Легкий</option>
                    <option value="средний">Средний</option>
                    <option value="сложный">Сложный</option>
                </select>
                @error('recipe_form.recipe_level')
                <span class="text-red-500 label-text-alt mb-3 mt-3">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </label>
            <x-mary-input type="number" class="input-sm" label="Примерная стоимость" wire:model="recipe_form.recipe_cost" suffix="Рублей" />
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Выберите национальность блюда</span>
                </div>
                <select wire:model="recipe_form.nation_id" class="select select-sm select-primary w-full select-bordered">
                    <option selected value="">Национальность блюда</option>
                    @foreach($nationalities as $nation)
                        <option value="{{ $nation->id }}">{{ $nation->title }}</option>
                    @endforeach
                </select>
                @error('recipe_form.nation_id')
                    <span class="text-red-500 label-text-alt mb-3 mt-3">
                            <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </label>
            <div x-data="{'modalTag': false}" class="flex items-end w-full">
                <div class="flex-grow">
                    <x-mary-choices-offline
                        wire:model.live="recipe_form.selectedTags"
                        :options="$tags"
                        option-label="title"
                        label="Выберите желаемые категории"
                        class="input-primary flex-grow rounded-r-none"
                        icon="o-hashtag"
                        searchable
                        no-result-text="ничего не нашли"
                    />
                </div>
                    <x-mary-icon @click="modalTag=true" name="o-plus-circle" class="h-[48px] p-1 bg-primary text-white cursor-pointer rounded-r-lg" />
                <div x-cloak x-show="modalTag"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="bg-black bg-opacity-50 fixed inset-0 backdrop-blur-sm"></div>
                    <div class="bg-base-100 rounded-lg shadow-lg z-10 m-2 p-10" @click.outside="modalTag=false">
                        <h2 class="text-xl mb-4">Введите название тега, который хотите добавить</h2>
                        <x-mary-input wire:model="tag_add_form.title" class="input-sm mb-2" label="Название" />
                        <div class="flex justify-end">
                            <button type="button" @click="modalTag = false" class="btn btn-secondary btn-sm mr-3">Отмена</button>
                            <button type="button" wire:click="add_tag" class="btn btn-accent btn-sm">
                                Сохранить
                                <span wire:target="add_tag" wire:loading class="hidden loading loading-spinner loading-sm"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" wire:click="save_recipe" wire:loading.attr="disabled" class="btn-outline btn-secondary mx-auto btn w-[150px]" >
                Сохранить
                     <span class="hidden loading loading-spinner loading-xs"
                           wire:loading.attr="disabled"
                           wire:target="save_recipe()"></span>
            </button>
        </form>
    @elseif($stage === 2)
        <div class="max-w-full overflow-x-auto mb-3">
            <table class="mx-auto table border border-primary">
                <!-- head -->
                <thead>
                <tr>
                    <th>№</th>
                    <th>Ингредиент</th>
                    <th>Количество</th>
                    <th>Мера</th>
                    <th>Примечание</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                @for($i = 0; $i < count($ingredients_data);$i++)
                    <tr>
                        <th>{{ $i+1 }}</th>
                        <td>{{ $ingredients_data[$i]['title'] }}</td>
                        <td>{{ $ingredients_data[$i]['value'] }}</td>
                        <td>{{ $ingredients_data[$i]['measure'] }}</td>
                        <td>{{ $ingredients_data[$i]['comment'] }}</td>
                        <td>
                            <x-mary-button wire:click="removeIngredient({{ $i }})" wire:loading.attr="disabled" icon="o-trash" class="btn-error btn-sm ">
                                     <span class="hidden loading loading-spinner loading-xs"
                                           wire:loading.class.remove="hidden"
                                           wire:target="removeIngredient"></span>
                            </x-mary-button>
                        </td>
                    </tr>
                @endfor

                </tbody>
            </table>
            @error('ingredients_data')
            <div class="text-center text-error">{{ $message }}</div>
            @enderror
        </div>
        <x-mary-button wire:click="save_ingredients" label="Сохранить" class="btn-sm btn-outline btn-secondary" />
        <form class="flex flex-col gap-3 p-3 lg:w-1/2 mx-auto " action="" method="get">
            <h1 class="text-center text-xl mb-5">Добавьте ингредиенты</h1>
            <div class="border border-white m-2 p-2 rounded-box flex flex-col gap-3">
                {{--                        <x-mary-errors title="Oops!" description="Please, fix them." icon="o-face-frown" />--}}

                <div x-data="{'modalIngredient': false}" class="flex items-end w-full">
                    <div class="flex-grow">
                        <x-mary-choices-offline
                            wire:model="ingredient_form.selectedIngredient"
                            :options="$ingredients"
                            option-label="title"
                            icon="o-beaker"
                            label="Выберите нужный ингредиент"
                            class="input-primary"
                            searchable
                            single
                            no-result-text="Ингредиент отсутствует"
                        />
                    </div>
                    <x-mary-icon @click="modalIngredient=true" name="o-plus-circle" class="ml-1 h-[48px] p-1 bg-primary text-white cursor-pointer rounded-full" />
                    <div x-cloak x-show="modalIngredient"
                         class="fixed inset-0 flex items-center justify-center z-50">
                        <div class="bg-black bg-opacity-50 fixed inset-0 backdrop-blur-sm"></div>
                        <div class="bg-base-100 rounded-lg shadow-lg z-10 m-2 p-10" @click.outside="modalIngredient=false">
                            <h2 class="text-xl mb-4">Введите название ингредиента, который хотите добавить</h2>
                            <x-mary-input wire:model="ingredient_add_form.title" class="input-sm mb-2" label="Название" />
                            <div class="flex justify-end">
                                <button type="button" @click="modalIngredient = false" class="btn btn-secondary btn-sm mr-3">Отмена</button>
                                <button type="button" wire:click="add_new_ingredient" class="btn btn-accent btn-sm">
                                    Сохранить
                                    <span wire:target="add_new_ingredient" wire:loading class="hidden loading loading-spinner loading-sm"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <x-mary-input min="1" wire:model="ingredient_form.value" type="number" class="input-sm" label="Количество">
                    <x-slot:append>
                        <x-mary-select :options="\App\Models\Ingredient::$measures" wire:model="ingredient_form.measure" option-value="value" option-label="value" class="select-sm rounded-l-none bg-base-100" />
                    </x-slot:append>
                </x-mary-input>
                <x-mary-input wire:model="ingredient_form.comment" class="input-sm mb-3" label="Примечание(необязательно)" />
            </div>

            <div class="buttons flex flex-wrap justify-around items-center" x-data="">
                <x-mary-button label="Прикрепить" ire:loading.attr="disabled" wire:click.debounce.0ms="addIngredient" icon="o-plus-circle" class="btn-success btn-sm" >
                        <span class="hidden loading loading-spinner loading-xs"
                              wire:loading.class.remove="hidden"
                              wire:target="addIngredient"></span>
                </x-mary-button>
            </div>


        </form>
    @elseif($stage === 3)
        <div class="w-2/3 overflow-x-auto scroll-smooth">
            <table class="mx-auto table border border-primary">
                <!-- head -->
                <thead>
                <tr>
                    <th>№</th>
                    <th>Описание</th>
                    <th>Картинка</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                @for($i = 0; $i < count($steps_data);$i++)
                    <tr>
                        <th>{{ $i+1 }}</th>
                        <td>{{ $steps_data[$i]['description'] }}</td>
                        <td>
                            @if(isset($steps_data[$i]['photo']))
                                <img alt="Шаг" wire:target="photo" src="{{ $steps_data[$i]['photo']->temporaryUrl() }}" class="w-[100px] mb-3 mr-3 rounded-box">
                            @elseif(isset($steps_data[$i]['photo_url']))
                                <img alt="Шаг" src="{{ asset($steps_data[$i]['photo_url'])  }}" class="w-[100px] mb-3 mr-3 rounded-box">
                            @endif
                        </td>
                        <td>
                            <x-mary-button wire:click="removeStep({{ $i }})" wire:loading.attr="disabled" icon="o-trash" class="btn-error btn-sm ">
                                     <span class="hidden loading loading-spinner loading-xs"
                                           wire:loading.class.remove="hidden"
                                           wire:target="removeStep"></span>
                            </x-mary-button>
                        </td>
                    </tr>
                @endfor

                </tbody>
            </table>
            @error('steps_data')
                <div class="text-center text-error">{{ $message }}</div>
            @enderror
        </div>
        <div x-data="">
            <x-mary-button wire:click="save_steps" wire:loading.attr="disabled" label="Сохранить"
                           class="btn-sm my-4 mx-auto btn-secondary"

            >
            <span class="hidden loading loading-spinner loading-xs"
                  wire:loading.class.remove="hidden"
                  wire:target="save_steps"></span>
            </x-mary-button>
        </div>

        <form class="flex flex-col gap-3 p-3 lg:w-1/2 mx-auto " action="" method="get">
            <h1 class="text-center text-xl mb-5">Добавьте Шаги</h1>
            <x-mary-textarea wire:model="step_form.description" label="Описание шага"/>
            <label class="form-control w-full max-w-xs mb-3">
                <div class="label">
                    <span class="label-text">Добавьте изображение(необязательно)</span>
                </div>
                <input wire:model="step_form.photo" type="file" class="file-input file-input-bordered file-input-primary file-input-sm w-full max-w-xs" />
                <div wire:loading.class.remove="hidden" wire:target="step_form.photo" class="hidden">
                    <x-mary-loading class="loading-infinity loading-lg block mx-auto" />
                </div>
                @if ($this->step_form->photo)
                    <div class="flex justify-start mt-3">
                        <img alt="Шаг" wire:target="photo" src="{{ $this->step_form->photo->temporaryUrl() }}" class="w-[100px] mb-3 mr-3 rounded-box">
                        <x-mary-button class="text-error" @click="$wire.step_form.photo=null; $wire.$refresh()" icon-right="o-x-circle" />
                    </div>
                    @error('step_form.photo')
                    <span class="text-error mb-3 mt-3">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                @endif
            </label>
            <div class="buttons flex flex-wrap justify-around items-center" x-data="">
                <x-mary-button label="Прикрепить" wire:click.debounce.0ms="addStep" wire:loading.attr="disabled" icon="o-plus-circle" class="btn-success btn-sm" >
                        <span class="hidden loading loading-spinner loading-xs"
                              wire:loading.class.remove="hidden"
                              wire:target="addStep"></span>
                </x-mary-button>
            </div>
        </form>

        @elseif($stage === 4)

        <div class="flex flex-col justify-center min-h-[70vh] items-center mx-auto justify-self-center">
            <button wire:click="complete()" wire:loading.remove type="button" class="btn btn-primary btn-outline">Нажмите, чтобы сформировать рецепт</button>
            <span wire:loading wire:target="complete" class="hidden loading loading-dots text-accent w-[180px] mx-auto"></span>
            <h2 class="hidden text-lg" wire:loading>Идет загрузка</h2>
        </div>


    @endif




</div>
