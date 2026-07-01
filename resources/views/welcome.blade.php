<x-layouts.app title="home">
    <h1 class="text-center">Hello</h1>
    <p class="text-center">Bienvenue sur Saone Local !</p>
    <p class="text-center">Notre api est disponible : <a href="https://saone-local.ddns.net/api">https://saone-local.ddns.net/</a></p>
    
    <div>
    </div>

    <div class="w-full p-2">
        <h1 class="font-bold rounded-2xl bg-base-green text-base-gray text-center p-2 text-2xl">nos produits</h1>
        <div class="flex flex-wrap gap-2 justify-center font-bold">
            @foreach($products as $product) 

                <x-cards 
                title="{{ $product->name }}"
                href="{{ route('products.show', $product->id) }}"
                image="{{ asset($product->image_path) }}"
                >
                <p>{{ $product->price }} €</p>
            </x-cards>
            @endforeach
        </div>
    </div>
    <div class="w-full p-2">
        <h1 class="font-bold rounded-2xl bg-base-green text-base-gray text-center p-2 text-2xl">nos producteurs</h1>
        <div class="flex flex-wrap gap-2 justify-center font-bold">
            @foreach($producers as $producer)

                <x-cards 
                title="{{ $producer->name }}"
                href="{{ route('producers.show', $producer->id) }}"
                image="{{ asset($producer->user->pdp_path) }}"
                >
                <p>{{ $producer->city }}</p>
            </x-cards>
            @endforeach
        </div>
    </div>
</x-layouts.app >