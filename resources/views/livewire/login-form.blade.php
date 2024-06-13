<div class="shadow-2xl w-full sm:w-1/2 p-4 rounded-box mx-auto">
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

        <div class="divider">Или</div>
        <a href="{{ route('auth.yandex') }}" class="btn flex items-center bg-base-100 border-none justify-center gap-3">
            Войти через
            <img src="{{ asset('assets/images/yandex.png') }}" width="45" alt="">
        </a>

        <x-slot:actions class="items-center justify-start">
            <x-mary-button label="Войти" wire:loading.attr="disabled" class="btn-accent btn-md " type="submit" />
            <a href="{{ route('register') }}" class="link-secondary self-center">Создать аккаунт?</a>
        </x-slot:actions>
    </x-mary-form>
</div>
