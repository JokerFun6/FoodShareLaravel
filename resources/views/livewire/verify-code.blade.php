<div class="w-full min-h-[70vh] flex flex-col gap-2 justify-center items-center" x-data="{
    showResendButton: false,
    strTime: null,
    time: 10,
    timerInterval: null,
    startTimer() {
        this.timerInterval = setInterval(() => {
            this.time--;
            this.strTime = this.formatTime()
            if (this.time === 0) {
                clearInterval(this.timerInterval);
                this.showResendButton = true;
            }
        }, 1000);
    },
    resetTimer() {
        clearInterval(this.timerInterval);
        this.time = 60;
        this.showResendButton = false;
        this.startTimer();
    },
    formatTime() {
        const minutes = Math.floor(this.time / 60);
        const seconds = this.time % 60;
        return `Повторная отправка через ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}" x-init="startTimer()" @resend.window="resetTimer() ;startTimer()">
    <h2 class="text-xl">Укажите код из сообщения:</h2>
    <x-mary-pin wire:model="code" size="4" numeric />
    @error('code')
        <div class="text-error">Неверный код подтверждения</div>
    @enderror
    <span wire:loading class="hidden loading loading-spinner loading-sm"></span>
    <div class="flex items-center flex-wrap justify-center sm:justify-between p-4 gap-5">
        <x-mary-button label="Подтвердить"  class="btn-sm btn-accent" wire:click="verify" />
        <template x-if="showResendButton">
            <x-mary-button icon="o-arrow-path" wire:click="resend_message" tooltip="Отправить заново" class="btn-circle btn-sm btn-warning" />
        </template>
        <template x-if="!showResendButton">
            <div x-text="strTime" class="text-sm"></div>
        </template>    </div>
</div>



