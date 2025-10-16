<x-card class="text-5xl bg-black flex justify-between"
    x-data="{
        h: Math.max({{ $hour }}, 0),
        m: Math.max({{ $minute }}, 0),
        s: Math.max({{ $second }}, 0),
        interval: null,
        tick() {
            if (this.h === 0 && this.m === 0 && this.s === 0) {
                // already expired
                $wire.examFinished()
                clearInterval(this.interval)
                return
            }

            if (this.s > 0) {
                this.s--
            } else if (this.m > 0) {
                this.m--
                this.s = 59
            } else if (this.h > 0) {
                this.h--
                this.m = 59
                this.s = 59
            } else {
                $wire.examFinished()
                clearInterval(this.interval)
            }
        }
    }"
    x-init="interval = setInterval(() => tick(), 1000)"
>
    <p class="text-md text-slate-600 font-bold">Duration</p>
    <div>
        <template x-if="h > 0 || m > 0 || s > 0">
            <span>
                <span x-text="String(h).padStart(2,'0')"></span> :
                <span x-text="String(m).padStart(2,'0')"></span> :
                <span x-text="String(s).padStart(2,'0')"></span>
            </span>
        </template>
        <template x-if="h === 0 && m === 0 && s === 0">
            <span>Time’s Up</span>
        </template>
    </div>
</x-card>
