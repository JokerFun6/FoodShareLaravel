<div class="form">
    <div class="rating flex flex-col justify-center items-center" x-data="{
            mark: @entangle('mark'),
            selectMark(value) {
                this.mark = value;
                if (value > 0) {
                    this.$wire.createMark();
                }
            }
        }">

            <div class="mb-3">
                <template x-for="value in [1, 2, 3, 4, 5]" :key="value">
                    <input
                        type="radio"
                        name="rating-2"
                        :value="value"
                        x-model="mark"
                        class="mask mask-star-2 bg-orange-400"
                    />
                </template>
            </div>
            <button
                type="button"
                x-show="mark > 0"
                @click="$wire.createMark"
                class="btn btn-warning btn-sm"
            >
                Оценить
            </button>

    </div>
</div>
