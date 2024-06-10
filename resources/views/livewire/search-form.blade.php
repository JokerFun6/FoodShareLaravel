<div class="form-control relative" x-data="{}">
    <label class="input input-sm input-bordered flex items-center gap-2">
         <input
            type="search"
            wire:model.live.debounce.300ms="query"
            x-on:blur="$wire.hideResults()"
            placeholder="Поиск"
            class="grow"
        />
        <span wire:loading.class.remove="hidden" wire:target="query"  class="hidden loading loading-spinner loading-sm"></span>
    </label>
    @if($showdiv)
        <ul class="menu menu-sm bg-neutral w-full rounded-box absolute top-10 left-[] z-[150]">
            @if(!empty($records))
                @foreach($records as $record)
                    <li><a href="{{ route('recipes.show', $record->slug_title) }}" >
                            <img src="{{ asset('storage/'.$record->photo_url) }}" class="rounded-md w-[64px]" alt="">
                            {{ $record->title }}
                        </a>
                    </li>
                @endforeach
                    <li><a wire:click="searchRecipe">
                            Искать все...
                        </a>
                    </li>
            @endif
        </ul>
    @endif
</div>
