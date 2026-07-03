@props(['title' => null, 'overflowHidden' => false])

<div x-data="{ open: false }" class="text-base-gray m-2">
    <div @click="open = !open" class="cursor-pointer bg-base-green flex items-center p-3 rounded-2xl font-bold select-none transition-opacity hover:opacity-90">
        @if(isset($header))
            {{ $header }}
        @else
            <p class="lg:text-2xl pl-2">{{ $title }}</p>
        @endif
        
        <div class="ml-auto pr-2 text-white">
            <x-icon x-show="!open" name="arrow-right" class="h-6 w-6 lg:h-8 lg:w-8" />
            <x-icon x-show="open" x-cloak name="arrow-down" class="h-6 w-6 lg:h-8 lg:w-8" />
        </div>
    </div>
    
    <div x-show="open" x-transition class="p-4 mt-2 text-left bg-stone-50 rounded-2xl border border-[#e3e3e0] {{ $overflowHidden ? 'overflow-hidden' : '' }}">
        {{ $slot }}
    </div>
</div>
