<x-layouts.app title="search">
    <x-dropdown width="w-48" align="right" >
        <x-slot name="trigger">
            <span class="inline-block h-8 w-8 lg:h-12 lg:w-12 m-1 lg:m-2 text-white hover:text-gray-300 transition-colors [&>svg]:w-full [&>svg]:h-full cursor-pointer">
                {!! file_get_contents(public_path('images/user.svg')) !!}
            </span>
        </x-slot>

    </x-dropdown>

    
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