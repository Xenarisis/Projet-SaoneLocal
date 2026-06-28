{{-- resources/views/components/dropdown.blade.php --}}

@props (['width'=> 'w-48', 'align' => 'left'])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open">
        {{ $trigger }}
    </button>

    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute top-full mt-2 {{ $width }} bg-white rounded-xl shadow-lg z-50 {{ $align === 'right' ? 'right-0' : 'left-0' }}"
        >
        {{ $slot }}
    </div>
</div>