<div class="form">
    <div class="rating flex flex-col justify-center items-center">
        <div class="mb-3">
            <input
                type="radio"
                name="rating-2"
                class="mask mask-star-2 bg-orange-400"
                value="1"
                wire:model="mark"
            />
            <input
                type="radio"
                name="rating-2"
                class="mask mask-star-2 bg-orange-400"
                value="2"
                wire:model="mark"
                checked
            />
            <input
                type="radio"
                name="rating-2"
                class="mask mask-star-2 bg-orange-400"
                value="3"
                wire:model="mark"
            />
            <input
                type="radio"
                name="rating-2"
                class="mask mask-star-2 bg-orange-400"
                value="4"
                wire:model="mark"
            />
            <input
                type="radio"
                name="rating-2"
                class="mask mask-star-2 bg-orange-400"
                value="5"
                wire:model="mark"
            />
        </div>

        <button wire:click="createMark" class="btn btn-warning btn-sm">Оценить</button>
    </div>
</div>
