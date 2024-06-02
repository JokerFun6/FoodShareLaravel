<div class="w-full min-h-[70vh] flex flex-col gap-2 justify-center items-center">
    <h2 class="text-xl">Укажите код из сообщения:</h2>
    <x-mary-pin wire:model="code" size="4" numeric />
    @error('code')
        <div class="text-error">Неверный код подтверждения</div>
    @enderror
    <span wire:loading class="hidden loading loading-spinner loading-sm"></span>
    <div class="flex items-center justify-between gap-5">
        <x-mary-button label="Подтвердить"  class="btn-sm btn-accent" wire:click="verify" />
        <x-mary-button icon="o-arrow-path" tooltip="Отправить заново" class="btn-circle btn-sm btn-warning" wire:click="resend_message"/>
    </div>


</div>
