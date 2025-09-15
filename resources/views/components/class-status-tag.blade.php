<label
  {{ $attributes->class([
      'text-slate-300 border border-slate-400 rounded-xl px-3 py-1 font-extrabold text-sm cursor-pointer',

      'text-slate-300 border border-slate-400 hover:text-slate-400' => $status == 'not_started',
      'border-success-500 text-success-700 hover:text-success-800' => $status == 'finished',
      'border-warning-600 text-warning-800 hover:text-warning-900' => $status == 'on_hold',
      'border-secondary-300 bg-secondary-400 text-white hover:text-secondary-600 font-semibold' => $status == 'published',
      'border-secondary-300  bg-secondary-400 text-white hover:text-secondary-300 font-extrabold' => $status == 'ongoing',
      'border-secondary-300 text-white hover:text-secondary-600 bg-secondary-400' => trim((string)$status) == 'clicked',
  ]) }}
>
  @if ($label == true)
      {{ $message }}
  @else
      {{ $slot }}
  @endif
</label>
