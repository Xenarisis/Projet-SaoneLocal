@props([
    'image' => null,
    'title',
    'place'=> null,
    'subtitle' => null,
    'badge' => null,
    'href' => '#'
])

<a href="{{ $href }}" class="flex flex-col h-full bg-base-gray dark:bg-cachou rounded-2xl shadow-sm hover:shadow-md transition border border-black dark:border-gray-600 overflow-hidden">
    @if($image)
    <div class="w-full aspect-[4/3] border-b border-black dark:border-gray-600 overflow-hidden bg-white dark:bg-gray-800">
        <img src="{{ $image }}" onerror="this.src='{{ asset('images/product.svg') }}'" alt="{{ $title }}" class="w-full h-full object-cover">
    </div>
    @endif

    <div class="p-4 flex flex-col flex-grow text-cachou dark:text-base-gray">
        @if($badge)
        <div class="mb-2">
            <span class="text-xs bg-base-green text-white px-2 py-1 rounded-full">{{ $badge }}</span>
        </div>
        @endif

        <h2 class="font-bold text-lg leading-tight">{{ $title }}</h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $place }}</p>

        @if($subtitle)
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $subtitle }}</p>
        @endif

        <div class="mt-auto pt-3 border-t border-black dark:border-gray-600">
            {{ $slot }}
        </div>
    </div>
</a>
