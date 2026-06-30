<x-layouts.app title="search">
    <div>
    </div>

    <div class="w-full p-2">
        <h1 class="font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl">nos produits</h1>
        <div class="flex flex-wrap gap-2 justify-center font-bold">
            @foreach($products as $product) 

                <x-cards 
                title="{{ $product->name }}"
                href="{{ route('products.show', $product->id) }}"
                ></x-cards>
            @endforeach
        </div>
    </div>
    <div class="w-full p-2">
        <h1 class="font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl">nos producteurs</h1>
        <div class="flex flex-wrap gap-2 justify-center font-bold">
            @foreach($producers as $producer)
                <x-cards 
                title="{{ $producer->name }}"
                href="{{ route('producers.show', $producer->id) }}"
                ></x-cards>
            @endforeach
        </div>
    </div>
</x-layouts.app >