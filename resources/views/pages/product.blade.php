<x-layouts.app title="{{ $product->name }}">
    <img src="{{ asset('images/product.jpg') }}" alt="{{ $product->name }}" class="w-full lg:h-248 rounded-2xl m-2">

    <h1 class="lg:text-2xl bg-base-green rounded-2xl text-base-gray text-center">{{ $product->name }}</h1>

    <div class="w-full flex justify-center">
        <button class="border-2 border-black rounded-2xl text-black p-2 mt-4"> Ajouter au panier +</button>
    </div>

    <div x-data="{ open: false }" class="cursor-pointer text-base-gray text-center rounded-2xl m-2">
        
        <div @click="open = !open" class="p-4">
            
            <p x-show="open">
                {{ $product->description }}
            </p>
            <div class=" bg-base-green flex flex-wrap gap-2 justify-center font-bold rounded-2xl p-2">
                <p class="lg:text-2xl rounded-2xl">
                    Description
                </p>
                
                <p x-show="!open" class=" ml-auto lg:text-2xl">></p>
                <p x-show="open" class=" ml-auto lg:text-2xl">v</p>
            </div>
            
        </div>
    </div>

    <div x-data="{ open: false }" class="cursor-pointer text-base-gray text-center rounded-2xl m-2">
        
        <div @click="open = !open" class="p-4">
            
            <p x-show="open">
                {{-- cards avis --}}
            </p>
            <div class=" bg-base-green flex flex-wrap gap-2 justify-center font-bold rounded-2xl p-2">
                <p class="lg:text-2xl rounded-2xl">
                    Avis clients
                </p>
                
                <p x-show="!open" class=" ml-auto lg:text-2xl">></p>
                <p x-show="open" class=" ml-auto lg:text-2xl">v</p>
            </div>
            
        </div>
    </div>

    <div x-data="{ open: false }" class="cursor-pointer text-base-gray text-center rounded-2xl m-2">
        
        <div @click="open = !open" class="p-4">
            
            <p x-show="open">
                {{-- cards produits --}}
            </p>
            <div class=" bg-base-green flex flex-wrap gap-2 justify-center font-bold rounded-2xl p-2">
                <p class="lg:text-2xl rounded-2xl">
                    Autres produits
                </p>
                
                <p x-show="!open" class=" ml-auto lg:text-2xl">></p>
                <p x-show="open" class=" ml-auto lg:text-2xl">v</p>
            </div>
            
        </div>
    </div>
</x-layoutsapp>