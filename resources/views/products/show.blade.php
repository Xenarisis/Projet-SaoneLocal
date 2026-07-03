<x-layouts.app title="{{ $product->name }} - SaôneLocal" description="Découvrez {{ $product->name }} proposé par {{ $product->producer->name ?? 'nos producteurs' }} sur SaôneLocal.">
    <div class="w-full">
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            <div class="w-full lg:w-[70%] shrink-0 flex items-end justify-center">
                <img src="{{ asset($product->image_path) }}" onerror="this.src='{{ asset('images/product.svg') }}'" alt="{{ $product->name }}" class="w-full h-auto max-h-[600px] object-contain">
            </div>

            <div class="w-full lg:w-[30%] flex flex-col justify-end">
                <div x-data="addToCart({{ $product->id }})" class="p-6 lg:p-8 bg-white border border-black rounded-3xl text-center flex flex-col items-center">
                    <h2 class="text-2xl lg:text-3xl font-bold mb-3 text-[#1B1B18]">{{ $product->name }}</h2>
                    @if($product->producer)
                        <p class="mb-3 text-sm text-[#706f6c]">
                            Vendu par <a href="{{ route('producers.show', $product->producer->id) }}" class="font-semibold underline hover:text-[#1B1B18] transition-colors">{{ $product->producer->name }}</a>
                        </p>
                    @endif
                    <p class="text-xl mb-6 text-[#706f6c] font-medium">{{ number_format($product->price, 2, ',', ' ') }} €</p>
                    
                    <p class="text-sm font-semibold text-gray-500 mb-2">En stock : {{ $product->quantity }}</p>
                    <div class="flex justify-center items-center gap-4 mb-6">
                        <button @click="quantity > 1 ? quantity-- : null" class="bg-gray-200 hover:bg-gray-300 w-10 h-10 flex justify-center items-center rounded-lg font-bold text-xl transition-colors text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">-</button>
                        <span class="text-2xl font-semibold w-10 text-center" x-text="quantity"></span>
                        <button @click="quantity < {{ $product->quantity }} ? quantity++ : null" :disabled="quantity >= {{ $product->quantity }}" class="bg-gray-200 hover:bg-gray-300 w-10 h-10 flex justify-center items-center rounded-lg font-bold text-xl transition-colors text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">+</button>
                    </div>
                    
                    <button @click="submit" :disabled="loading" class="bg-red-blood text-white font-bold py-3 px-6 text-base lg:text-lg rounded-full w-full mx-auto hover:opacity-80 disabled:opacity-70 disabled:cursor-not-allowed transition-colors shadow-md">
                        <span x-show="!loading">Ajouter au panier</span>
                        <span x-show="loading">Ajout en cours...</span>
                    </button>
                </div>
            </div>
        </div>

    <x-accordion title="Description">
        <p class="text-[#706f6c] leading-relaxed">
            {{ $product->description ?: 'Aucune description fournie par le producteur.' }}
        </p>
    </x-accordion>

    <x-accordion>
        <x-slot:header>
            <div class="flex items-center gap-2 pl-2">
                <p class="lg:text-2xl">Avis clients</p>
                @if($product->reviews->count() > 0)
                    <span class="flex items-center gap-1 text-lg">
                        <x-icon name="star" class="h-5 w-5 lg:h-6 lg:w-6 text-[#F8B803]" />
                        {{ number_format($product->reviews->avg('rating'), 1, ',', '') }}
                    </span>
                @endif
            </div>
        </x-slot:header>

        @if($product->reviews->count() > 0)
            <div class="flex flex-col gap-4">
            @foreach($product->reviews as $review)
                <x-review-card :review="$review" />
            @endforeach
            </div>
        @else
            <p class="text-center text-[#706f6c] italic">Aucun avis pour le moment.</p>
        @endif
    </x-accordion>

    <x-accordion title="Autres produits" overflowHidden="true">
        @if($producerProducts->count() > 0)
            <h3 class="font-bold text-xl mb-2 text-[#1B1B18]">Du même producteur</h3>
            <div class="flex overflow-x-auto gap-4 pb-6 snap-x no-scrollbar">
                @foreach($producerProducts as $prod)
                    <div class="snap-start shrink-0 w-48 lg:w-56">
                        <x-cards 
                            title="{{ $prod->name }}"
                            subtitle="{{ $prod->producer->name ?? '' }}"
                            href="{{ route('products.show', $prod->id) }}"
                            image="{{ asset($prod->image_path) }}"
                        >
                            <p>{{ $prod->price }} €</p>
                        </x-cards>
                    </div>
                @endforeach
            </div>
        @endif

        @if($similarProducts->count() > 0)
            <h3 class="font-bold text-xl mb-2 mt-4 text-[#1B1B18]">Produits similaires</h3>
            <div class="flex overflow-x-auto gap-4 pb-6 snap-x no-scrollbar">
                @foreach($similarProducts as $prod)
                    <div class="snap-start shrink-0 w-48 lg:w-56">
                        <x-cards 
                            title="{{ $prod->name }}"
                            subtitle="{{ $prod->producer->name ?? '' }}"
                            href="{{ route('products.show', $prod->id) }}"
                            image="{{ asset($prod->image_path) }}"
                        >
                            <p>{{ $prod->price }} €</p>
                        </x-cards>
                    </div>
                @endforeach
            </div>
        @endif

        @if($producerProducts->count() == 0 && $similarProducts->count() == 0)
            <p class="text-center text-[#706f6c] italic">
                Aucun autre produit pour le moment.
            </p>
        @endif
    </x-accordion>
    </div>
</x-layouts.app>