<x-layouts.app title="{{ $producer->name }} - Producteur SaôneLocal" description="Découvrez les produits locaux de {{ $producer->name }}, producteur basé à {{ $producer->city }}.">
    <div class="w-full">
        <div class="w-full flex justify-center mb-6">
            <img src="{{ asset($producer->user->pdp_path ?? 'images/producter.jpg') }}" alt="{{ $producer->name }}" class="w-full max-w-4xl h-auto max-h-[400px] object-cover rounded-2xl border-[3px] border-[#1B1B18] shadow-sm">
        </div>

    <h1 class="lg:text-2xl bg-base-green rounded-2xl text-base-gray text-center mb-8 p-4 font-bold shadow-sm">{{ $producer->name }}</h1>

    <x-accordion title="Présentation">
        <p class="text-[#706f6c] leading-relaxed">
            {{ $producer->presentation ?: 'Aucune présentation fournie pour le moment.' }}
        </p>
    </x-accordion>

    <x-accordion>
        <x-slot:header>
            <div class="flex items-center gap-2 pl-2">
                <p class="lg:text-2xl">Avis clients</p>
                @if($producer->reviews->count() > 0)
                    <span class="flex items-center gap-1 text-lg">
                        <x-icon name="star" class="h-5 w-5 lg:h-6 lg:w-6 text-[#F8B803]" />
                        {{ number_format($producer->reviews->avg('rating'), 1, ',', '') }}
                    </span>
                @endif
            </div>
        </x-slot:header>

        @if($producer->reviews->count() > 0)
            <div class="flex flex-col gap-4">
            @foreach($producer->reviews as $review)
                <x-review-card :review="$review">
                    @if($review->product)
                        <span class="text-xs font-bold text-gray-400 block mb-1 mt-2">À propos de : {{ $review->product->name }}</span>
                    @endif
                </x-review-card>
            @endforeach
            </div>
        @else
            <p class="text-center text-[#706f6c] italic">Aucun avis pour le moment.</p>
        @endif
    </x-accordion>

    <x-accordion title="Produits" overflowHidden="true">
        @if($producer->products && $producer->products->count() > 0)
            <div class="flex overflow-x-auto gap-4 pb-6 snap-x no-scrollbar">
                @foreach($producer->products as $prod)
                    <div class="snap-start shrink-0 w-48 lg:w-56">
                        <x-cards 
                            title="{{ $prod->name }}"
                            subtitle="{{ $producer->name }}"
                            href="{{ route('products.show', $prod->id) }}"
                            image="{{ asset($prod->image_path) }}"
                        >
                            <p>{{ $prod->price }} €</p>
                        </x-cards>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-[#706f6c] italic">Aucun produit pour le moment.</p>
        @endif
    </x-accordion>
    </div>
</x-layouts.app>