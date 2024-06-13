<div class="shadow-2xl w-full sm:w-1/2 p-4 rounded-box mx-auto" x-data="{showModal: false}">
    <h2 class="text-xl text-center mb-2">
        Авторизуйтесь в системе
        <img src="{{ asset('assets/images/logo-small.png') }}" class="mx-auto w-[100px]" alt="">
    </h2>
    <x-mary-form wire:submit="login">
        {{-- Full error bag --}}
        {{-- All attributes are optional, remove it and give a try--}}

        <x-mary-input label="E-mail или логин" wire:model="email" class="focus:ring-white-100" icon="o-envelope" inline />
        <x-mary-input label="Пароль" type="password" wire:model="password" icon="o-lock-closed" inline />
        <x-mary-checkbox class="checkbox checkbox-primary" label="Запомнить меня" wire:model="remember"/>

        <x-slot:actions class="items-center justify-start">
            <div class="w-full">
                <div class="flex w-full justify-between items-center flex-wrap gap-3">
                    <div class="flex gap-3 items-center">
                        <x-mary-button label="Войти" wire:loading.attr="disabled" class="btn-accent btn-md " type="submit" />
                        <a href="{{ route('register') }}" class="link-secondary self-center">Создать аккаунт?</a>
                    </div>
                    <button @click="showModal = true" type="button" class="btn btn-warning btn-outline btn-sm">Забыли пароль?</button>
                </div>
                <div class="divider">Или</div>
                <a href="{{ route('auth.yandex') }}" class="btn flex items-center bg-base-100 border-none justify-center gap-3">
                    Войти через
                    <img src="{{ asset('assets/images/yandex.png') }}" width="45" alt="">
                </a>
            </div>

        </x-slot:actions>

    </x-mary-form>
    <div x-cloak x-show="showModal"
         @keyup.escape.document="showModal=false"
         class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-black bg-opacity-50 fixed inset-0 backdrop-blur-sm"></div>
        <div class="w-full sm:w-1/2 bg-base-100 rounded-lg shadow-lg z-10 m-2 p-10" @click.outside="showModal=false">
            <h2 class="text-xl mb-4">Сброс пароля</h2>
            <x-mary-input wire:model="reset_email" class="input-sm mb-2" label="Укажите вашу почту" />
            <div class="flex justify-end gap-3">
                <button @click="showModal = false" class="btn btn-secondary btn-sm mr-3">Отмена</button>
                <button wire:click="reset_password()" class="btn btn-warning btn-outline btn-sm">Сбросить</button>
            </div>
        </div>
    </div>
</div>
