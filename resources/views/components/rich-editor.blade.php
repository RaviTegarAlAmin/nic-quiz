@props([
    'wireModel' => null,   // e.g. 'content'
    'placeholder' => 'Tulis soal di sini...',
    'label' => null,
    'height' => '120px',
])

{{-- Scoped ID so multiple editors can live on one page --}}
@php $uid = 'tiptap_' . uniqid(); @endphp

<div {{ $attributes->only('class') }}>

    @if ($label)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">{{ $label }}</label>
    @endif

    <div
        x-data="tiptapEditor({
            content: @if($wireModel) $wire.entangle('{{ $wireModel }}') @else '' @endif,
            onChange: (html) => @if($wireModel) $wire.set('{{ $wireModel }}', html) @else null @endif,
        })"
        x-init="init()"
        wire:ignore
        class="w-full overflow-hidden rounded-md border border-primary-100 ring-1 ring-slate-300 bg-white shadow-sm transition focus-within:border-primary-400 focus-within:ring-1 focus-within:ring-primary-400"
    >

        {{-- ── TOOLBAR ── --}}
        <div class="relative flex flex-wrap items-center gap-0.5 border-b border-slate-100 bg-slate-50 px-2 py-1.5">

            {{-- History --}}
            <div class="flex items-center gap-0.5 pr-2 mr-1 border-r border-slate-200">
                <x-editor-btn tooltip="Undo" x-on:mousedown.prevent.stop="undo()">
                    <x-icons.editor.undo />
                </x-editor-btn>
                <x-editor-btn tooltip="Redo" x-on:mousedown.prevent.stop="redo()">
                    <x-icons.editor.redo />
                </x-editor-btn>
            </div>

            {{-- Headings --}}
            <div class="flex items-center gap-0.5 pr-2 mr-1 border-r border-slate-200">
                <x-editor-btn tooltip="Heading 1" x-on:mousedown.prevent.stop="toggleHeading(1)" active="isHeading(1)">
                    <span class="text-xs font-bold leading-none">H1</span>
                </x-editor-btn>
                <x-editor-btn tooltip="Heading 2" x-on:mousedown.prevent.stop="toggleHeading(2)" active="isHeading(2)">
                    <span class="text-xs font-bold leading-none">H2</span>
                </x-editor-btn>
            </div>

            {{-- Text formatting --}}
            <div class="flex items-center gap-0.5 pr-2 mr-1 border-r border-slate-200">
                <x-editor-btn tooltip="Bold" x-on:mousedown.prevent.stop="toggleBold()" active="isActive('bold')">
                    <x-icons.editor.bold />
                </x-editor-btn>
                <x-editor-btn tooltip="Italic" x-on:mousedown.prevent.stop="toggleItalic()" active="isActive('italic')">
                    <x-icons.editor.italic />
                </x-editor-btn>
                <x-editor-btn tooltip="Underline" x-on:mousedown.prevent.stop="toggleUnderline()" active="isActive('underline')">
                    <x-icons.editor.underline />
                </x-editor-btn>
                <x-editor-btn tooltip="Strikethrough" x-on:mousedown.prevent.stop="toggleStrike()" active="isActive('strike')">
                    <x-icons.editor.strike />
                </x-editor-btn>
            </div>

            {{-- Alignment --}}
            <div class="flex items-center gap-0.5 pr-2 mr-1 border-r border-slate-200">
                <x-editor-btn tooltip="Align Left" x-on:mousedown.prevent.stop="alignLeft()" active="isAlign('left')">
                    <x-icons.editor.align-left />
                </x-editor-btn>
                <x-editor-btn tooltip="Align Center" x-on:mousedown.prevent.stop="alignCenter()" active="isAlign('center')">
                    <x-icons.editor.align-center />
                </x-editor-btn>
                <x-editor-btn tooltip="Align Right" x-on:mousedown.prevent.stop="alignRight()" active="isAlign('right')">
                    <x-icons.editor.align-right />
                </x-editor-btn>
                <x-editor-btn tooltip="Justify" x-on:mousedown.prevent.stop="alignJustify()" active="isAlign('justify')">
                    <x-icons.editor.align-justify />
                </x-editor-btn>
            </div>

            {{-- Lists --}}
            <div class="flex items-center gap-0.5 pr-2 mr-1 border-r border-slate-200">
                <x-editor-btn tooltip="Bullet List" x-on:mousedown.prevent.stop="toggleBulletList()" active="isActive('bulletList')">
                    <x-icons.editor.list />
                </x-editor-btn>
                <x-editor-btn tooltip="Numbered List" x-on:mousedown.prevent.stop="toggleOrderedList()" active="isActive('orderedList')">
                    <x-icons.editor.list-ordered />
                </x-editor-btn>
            </div>

            {{-- Table --}}
            <div class="flex items-center gap-0.5" x-data="{ tableOpen: false }">
                <x-editor-btn tooltip="Insert Table" x-on:mousedown.prevent.stop="tableOpen = !tableOpen" active="tableOpen">
                    <x-icons.editor.table />
                </x-editor-btn>

                <div x-show="tableOpen" x-cloak @click.outside="tableOpen = false"
                    class="absolute mt-1 bg-white border border-slate-200 rounded-lg shadow-lg p-2 z-50 flex flex-wrap gap-1 w-48">
                    <button @click="insertTable(); tableOpen = false"
                        class="w-full text-left text-xs px-2 py-1.5 rounded hover:bg-slate-100">
                        + Insert Table (3×3)
                    </button>
                    <button @click="addColumnAfter()"
                        class="w-full text-left text-xs px-2 py-1.5 rounded hover:bg-slate-100">
                        Add Column →
                    </button>
                    <button @click="deleteColumn()"
                        class="w-full text-left text-xs px-2 py-1.5 rounded hover:bg-slate-100 text-danger-600">
                        Delete Column
                    </button>
                    <button @click="addRowAfter()"
                        class="w-full text-left text-xs px-2 py-1.5 rounded hover:bg-slate-100">
                        Add Row ↓
                    </button>
                    <button @click="deleteRow()"
                        class="w-full text-left text-xs px-2 py-1.5 rounded hover:bg-slate-100 text-danger-600">
                        Delete Row
                    </button>
                    <div class="w-full border-t border-slate-100 mt-1 pt-1">
                        <button @click="deleteTable(); tableOpen = false"
                            class="w-full text-left text-xs px-2 py-1.5 rounded hover:bg-danger-50 text-danger-600">
                            Delete Table
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── EDITOR AREA ── --}}
        <div
            x-ref="editorEl"
            style="min-height: {{ $height }}"
            class="relative w-full"
        >
            {{-- Placeholder --}}
            <p x-show="!hasContent"
               class="pointer-events-none absolute left-3 top-2 text-sm text-slate-400 select-none"
               x-transition.opacity
            >{{ $placeholder }}</p>
        </div>

    </div>

</div>
