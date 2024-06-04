<div class="shadow-2xl w-full sm:w-1/2 p-4 rounded-box border-white mx-auto">
    <h2 class="text-xl text-center mb-2">
        Создайте аккаунт
        <img src="{{ asset('assets/images/logo-small.png') }}" class="mx-auto w-[100px]" alt="">
    </h2>
    <x-mary-form wire:submit="register">
        {{-- Full error bag --}}
        {{-- All attributes are optional, remove it and give a try--}}
        <x-mary-input label="Логин" wire:model="login" class="focus:ring-white-100" icon="o-user" inline/>
        <x-mary-input label="E-mail" wire:model="email" class="focus:ring-white-100" icon="o-envelope" inline/>
        <x-mary-input label="Пароль" type="password" wire:model="password" icon="o-lock-closed" inline/>
        <x-mary-input label="Подтверждение пароля" type="password" wire:model="password_confirmation" icon="o-lock-closed" inline />
        <x-mary-checkbox class="checkbox checkbox-primary" label="Вы согласны с обработкой ваших персональных данных?" wire:model="agree"/>

        <x-slot:actions class="items-center">
            <x-mary-button label="Создать аккаунт" wire:loading.attr="disabled" class="btn-accent btn-md px-3" type="submit" />
            <a href="{{ route('login') }}" class="link-secondary self-center">Есть аккаунт?</a>
        </x-slot:actions>
    </x-mary-form>
</div>
