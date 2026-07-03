@props([
    'avatarUrl' => null,
    'altText' => 'Avatar'
])

<div {{ $attributes->merge(['class' => 'flex shrink-0 items-center justify-center overflow-hidden rounded-full bg-cachou']) }}>
    @if($avatarUrl)
        <img 
            src="{{ $avatarUrl }}" 
            alt="{{ $altText }}" 
            class="h-full w-full object-cover text-white"
        >
    @else
        <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
            {{ strtoupper(substr($altText, 0, 1)) }}
        </div>
    @endif
</div>