@props([
    'image' => null,
    'title',
    'place'=> null,
    'subtitle' => null,
    'badge' => null,
    'href' => '#',
    'productId' => null,
    'producerId' => null
])

<div class="relative flex flex-col h-full bg-base-gray dark:bg-cachou rounded-2xl shadow-sm hover:shadow-md transition border border-black dark:border-gray-600 overflow-hidden group">
    @if($productId)
    <button @click.prevent="$store.favorites.toggleProduct({{ $productId }})" class="absolute top-2 right-2 bg-white/80 dark:bg-gray-800/80 p-1.5 rounded-full hover:bg-white transition-colors z-10" :title="$store.favorites.isProductBookmarked({{ $productId }}) ? 'Retirer des favoris' : 'Ajouter aux favoris'">
        <template x-if="$store.favorites.isProductBookmarked({{ $productId }})">
            <img src="{{ asset('images/bookmarks-fill.svg') }}" class="w-5 h-5 text-[#F8B803]" alt="Favori">
        </template>
        <template x-if="!$store.favorites.isProductBookmarked({{ $productId }})">
            <img src="{{ asset('images/bookmarks.svg') }}" class="w-5 h-5" alt="Favori">
        </template>
    </button>
    @elseif($producerId)
    <button @click.prevent="$store.favorites.toggleProducer({{ $producerId }})" class="absolute top-2 right-2 bg-white/80 dark:bg-gray-800/80 p-1.5 rounded-full hover:bg-white transition-colors z-10" :title="$store.favorites.isProducerFollowed({{ $producerId }}) ? 'Ne plus suivre' : 'Suivre'">
        <template x-if="$store.favorites.isProducerFollowed({{ $producerId }})">
            <img src="{{ asset('images/bookmarks-fill.svg') }}" class="w-5 h-5 text-[#F8B803]" alt="Suivi">
        </template>
        <template x-if="!$store.favorites.isProducerFollowed({{ $producerId }})">
            <img src="{{ asset('images/bookmarks.svg') }}" class="w-5 h-5" alt="Suivre">
        </template>
    </button>
    @endif

    <a href="{{ $href }}" class="flex flex-col flex-grow">
        @if($image)
        <div class="w-full aspect-[4/3] border-b border-black dark:border-gray-600 overflow-hidden bg-white dark:bg-gray-800">
            <img src="{{ $image }}" onerror="this.src='{{ asset('images/product.svg') }}'" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
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
</div>
