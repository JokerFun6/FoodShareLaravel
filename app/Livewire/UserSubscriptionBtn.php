<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class UserSubscriptionBtn extends Component
{
    use Toast;
    public $userId;

    public function subscribe()
    {
        $user = Auth::user();
        $targetUser = User::find($this->userId);

        // Проверка, чтобы пользователь не мог подписаться сам на себя
        if ($user->id == $this->userId) {
            return;
        }

        // Проверка, если уже есть подписка
        if ($user->subscriptions()->where('subscribed_to_id', $this->userId)->exists()) {
            $user->subscriptions()->detach($targetUser->id);
            return $this->info('Подписка отменена');
        } else {
            $user->subscriptions()->attach($targetUser->id);
            return $this->info('Вы подписались');
        }
    }
    public function render()
    {
        $isSubscribed = Auth::user()?->subscriptions->contains($this->userId);
        return view('livewire.user-subscription-btn', ['isSubscribed' => $isSubscribed]);
    }
}
