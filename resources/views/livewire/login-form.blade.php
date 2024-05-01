<div class="bg-accent w-full sm:w-1/2 p-4 rounded-box mx-auto">
    <h2 class="text-xl text-center">
        Авторизуйтесь в системе
        <img src="{{ asset('assets/images/logo.png') }}" class="mx-auto w-1/2" alt="">
    </h2>
    <x-mary-form wire:submit="login">
        {{-- Full error bag --}}
        {{-- All attributes are optional, remove it and give a try--}}

        <x-mary-input label="E-mail" wire:model="email" class="focus:ring-white-100" icon="o-envelope" inline />
        <x-mary-input label="Пароль" type="password" wire:model="password" icon="o-lock-closed" inline />
        <x-mary-checkbox class="checkbox checkbox-info" label="Запомнить меня" wire:model="remember"/>

        <x-slot:actions class="items-center">
            <x-mary-button label="Войти" wire:loading.attr="disabled" class="btn-info btn-md " type="submit" />
            <a href="{{ route('register') }}" class="link-secondary self-center">Создать аккаунт?</a>
        </x-slot:actions>
    </x-mary-form>
</div>
