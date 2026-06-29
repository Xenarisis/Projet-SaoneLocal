@props([
    'image' => null,
    'title',
    'place'=> null,
    'subtitle' => null,
    'badge' => null,
    'href' => '#'
])

<a href="{{ $href }}" class="block bg-[#DEDEDE] rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
    
    @if($image)
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
    @endif

    <div class="p-4">
        @if($badge)
        <span class="text-xs bg-[#057941] text-white px-2 py-1 rounded-full">{{ $badge }}</span>
        @endif

        <h2 class="font-bold text-lg mt-2">{{ $title }}</h2>

        <p class="text-sm text-gray-500">{{ $place }}</p>

        @if($subtitle)
        <p class="text-sm text-gray-500">{{ $subtitle }}</p>
        @endif

        {{ $slot }}
    </div>

</a>