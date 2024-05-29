<div>
    <x-mary-button
        wire:click="subscribe"
        class="btn btn-primary btn-outline btn-sm"
        wire:loading.attr.remove="icon-right"
        icon-right="{{ $isSubscribed ? 'o-x-mark' : 'o-check' }}"
        >
        {{ $isSubscribed ? 'Отписаться' : 'Подписаться' }}
        <span wire:loading="subscribe" class="hidden loading loading-spinner text-accent"></span>
    </x-mary-button>
</div>
