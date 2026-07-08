<x-layouts.app title="SaôneLocal - Découvrez vos producteurs locaux" description="Achetez des produits frais et locaux directement auprès des producteurs de la région sur SaôneLocal.">
    <div class="w-full p-2 mb-8">
        <h1 class="font-bold rounded-2xl bg-base-green text-base-gray text-center p-2 text-2xl mb-6">Nos Produits</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product) 

                <x-cards 
                title="{{ $product->name }}"
                subtitle="{{ $product->producer->name ?? '' }}"
                href="{{ route('products.show', $product->id) }}"
                image="{{ asset($product->image_path) }}"
                productId="{{ $product->id }}"
                >
                <p class="text-lg text-emerald-700 font-bold">{{ number_format($product->price, 2, ',', ' ') }} €</p>
            </x-cards>
            @endforeach
        </div>
    </div>
    <div class="w-full p-2">
        <h1 class="font-bold rounded-2xl bg-base-green text-base-gray text-center p-2 text-2xl mb-6">Nos Producteurs</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($producers as $producer)

                <x-cards 
                title="{{ $producer->name }}"
                href="{{ route('producers.show', $producer->id) }}"
                image="{{ asset($producer->user->pdp_path ?? 'images/producter.jpg') }}"
                producerId="{{ $producer->id }}"
                >
                <p class="font-bold">{{ $producer->city }}</p>
            </x-cards>
            @endforeach
        </div>
    </div>
</x-layouts.app>