@extends('layouts.base')

@section('title')
    Личный кабинет пользователя
@endsection

@section('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
@endsection

@section('content')
    <main class="mx-auto max-w-[1440px] mt-4 p-3">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="form-update col-span-full md:col-span-1 p-3 shadow-xl rounded-box">
               <livewire:profile-update />
            </div>
            <div class="form-update col-span-full md:col-span-2 shadow-xl rounded-box border border-white">
                <div x-data="{ activeTab: 'tab1' }" class="w-full">
                    <nav class="grid grid-cols-2 mb-4">
                        <button
                            class="px-4 py-2 font-medium border border-neutral bg-primary rounded-lg"
                            :class="{ 'bg-primary text-white': activeTab === 'tab1' }"
                            @click="activeTab = 'tab1'">
                            Мои рецепты
                            <div class="badge badge-outline">{{ $recipes->count() }}</div>
                        </button>
                        <button
                            class="px-4 py-2 font-medium border border-neutral bg-primary rounded-lg"
                            :class="{ 'bg-primary text-white': activeTab === 'tab2' }"
                            @click="activeTab = 'tab2'">
                            Мои подписки
                            <div class="badge badge-outline">{{ $subcriptions->count() }}</div>
                        </button>
                    </nav>

                    <div>
                        <div x-show="activeTab === 'tab1'" class="" x-transition>
                            <livewire:users-recipes />
                        </div>

                        <div x-cloak x-show="activeTab === 'tab2'" class="" x-transition>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 p-3" x-data="{ showModal2: false, userId: null }">
                                @forelse($subcriptions as $subcription)
                                    <div class="bg-base-100 grid grid-cols-2 justify-center gap-2 items-center rounded-lg shadow-lg p-6 w-full text-center">
                                        <a href="{{ route('users.index', $subcription->id) }}" wire:navigate>
                                            <img src="{{ asset('storage/' . $subcription->avatar_url) }}" alt="User Avatar" class="w-20 h-20 mx-auto rounded-full">
                                        </a>
                                        <div class="text-xl font-semibold">{{ $subcription->login }}</div>
                                        <div class="col-span-full">
                                            <livewire:user-subscription-btn class="" :user-id="$subcription->id"/>
                                        </div>
                                    </div>
                                @empty
                                    <h2 class="text-center">У вас пока нет подписок</h2>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
