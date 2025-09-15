<x-card class="text-5xl bg-black flex justify-between" wire:poll.60s.keep-alive="heartbeat"
    x-data="{
        h: {{ $hour }},
        m: {{ $minute }},
        s: {{ $second }},
        tick() {
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
    }" x-init="setInterval(() => tick(), 1000)">
    <p class="text-md text-slate-600 font-bold">Durasi</p>
    <div>
        <span x-text="String(h).padStart(2,'0')"></span> :
        <span x-text="String(m).padStart(2,'0')"></span> :
        <span x-text="String(s).padStart(2,'0')"></span>
    </div>
</x-card>
