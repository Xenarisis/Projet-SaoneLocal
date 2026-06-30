<x-layouts.app title="{{ $producer->name }}">
    <img src="{{ asset('images/producter.jpg') }}" alt="{{ $producer->name }}" class="w-full lg:h-248 rounded-2xl m-2">

    <div x-data="{ open: false }" class="cursor-pointer text-base-gray text-center rounded-2xl m-2">
        
        <div @click="open = !open" class="p-4">
            
            <p x-show="open">
                {{ $producer->description }}
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
                    Produits
                </p>
                
                <p x-show="!open" class=" ml-auto lg:text-2xl">></p>
                <p x-show="open" class=" ml-auto lg:text-2xl">v</p>
            </div>
            
        </div>
    </div>
</x-layoutsapp>