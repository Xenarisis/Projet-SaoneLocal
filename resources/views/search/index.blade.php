<x-layouts.app title="search">
    <div x-data="{ openFilters: false }">

    <div class="flex items-center gap-2 mb-2">
        <button @click="openFilters = !openFilters">
            {!! file_get_contents(public_path('images/filter.svg')) !!}
        </button>
        <input 
            type="search"
            name="q"
            form="search-form"
            value="{{ request('q') }}"
            placeholder="Rechercher..."
            class="flex-1 rounded-full border outline-none p-2 px-4"
        >
    </div>

    <form id="search-form" action="{{ route('search') }}" method="GET">
        <input type="hidden" name="q" value="{{ request('q') }}">

        <div x-show="openFilters" x-transition class="bg-white rounded-2xl shadow-lg p-4 mb-4 flex flex-col gap-3">

            <div>
                <label class="text-sm font-medium text-gray-600">Rechercher parmi</label>
                <div class="flex gap-2 mt-1">
                    <label class="flex-1">
                        <input type="radio" name="type" value="producers/products" {{ request('type') === 'producers/products' ? 'checked' : '' }} class="hidden peer">
                        <span class="block text-center rounded-full py-1.5 text-sm border peer-checked:bg-[#820606] peer-checked:text-white cursor-pointer">
                            Producteurs et Produits
                        </span>
                    </label>
                    <label class="flex-1">
                        <input type="radio" name="type" value="products" {{ request('type', 'products') === 'products' ? 'checked' : '' }} class="hidden peer">
                        <span class="block text-center rounded-full py-1.5 text-sm border peer-checked:bg-[#820606] peer-checked:text-white cursor-pointer">
                            Produits
                        </span>
                    </label>
                    <label class="flex-1">
                        <input type="radio" name="type" value="producers" {{ request('type') === 'producers' ? 'checked' : '' }} class="hidden peer">
                        <span class="block text-center rounded-full py-1.5 text-sm border peer-checked:bg-[#820606] peer-checked:text-white cursor-pointer">
                            Producteurs
                        </span>
                    </label>
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-600">Catégorie</label>
                <select name="category" class="w-full mt-1 rounded-full px-4 py-2 border outline-none">
                    <option value="">Toutes</option>
                    <option value="fruits" {{ request('category') === 'fruits' ? 'selected' : '' }}>Fruits</option>
                    <option value="legumes" {{ request('category') === 'legumes' ? 'selected' : '' }}>Légumes</option>
                    <option value="vins" {{ request('category') === 'vins' ? 'selected' : '' }}>Vins</option>
                </select>
            </div>

            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="text-sm font-medium text-gray-600">Prix min (€)</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0"
                        class="w-full mt-1 rounded-full px-4 py-2 border outline-none">
                </div>
                <div class="flex-1">
                    <label class="text-sm font-medium text-gray-600">Prix max (€)</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="100"
                        class="w-full mt-1 rounded-full px-4 py-2 border outline-none">
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('search') }}" class="flex-1 text-center rounded-full border py-2 text-sm text-gray-600 hover:bg-gray-100">
                    Réinitialiser
                </a>
                <button type="submit" class="flex-1 rounded-full bg-[#820606] text-white py-2 text-sm">
                    Appliquer
                </button>
            </div>

        </div>
    </form>

    @if(request('type', 'products') === 'products')

        <h1 class="w-full font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl mb-3">Nos produits</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="font-bold text-lg">{{ $product->name }}</h2>
                        <p class="text-[#820606] font-bold mt-1">{{ $product->price }} €</p>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500">Aucun produit trouvé.</p>
            @endforelse
        </div>

    @elseif(request('type') === 'producers')

        <h1 class="w-full font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl mb-3">Nos producteurs</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($producers as $producer)
                <a href="{{ route('producers.show', $producer->id) }}" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $producer->user?->pdp_path) }}" alt="{{ $producer->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="font-bold text-lg">{{ $producer->name }}</h2>
                        <p class="text-gray-500 text-sm mt-1">{{ $producer->city }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500">Aucun producteur trouvé.</p>
            @endforelse
        </div>

    @else
    <h1 class="w-full font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl mb-3">Nos produits</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @forelse($products as $product)
                <a href="{{ route('products.show', $product->id) }}" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('storage/products/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="font-bold text-lg">{{ $product->name }}</h2>
                        <p class="text-[#820606] font-bold mt-1">{{ $product->price }} €</p>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500">Aucun produit trouvé.</p>
            @endforelse
        </div>

    <h1 class="w-full font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl mb-3">Nos producteurs</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($producers as $producer)
                <a href="{{ route('producers.show', $producer->id) }}" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $producer->user?->pdp_path) }}" alt="{{ $producer->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="font-bold text-lg">{{ $producer->name }}</h2>
                        <p class="text-gray-500 text-sm mt-1">{{ $producer->city }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500">Aucun producteur trouvé.</p>
            @endforelse
        </div>
    @endif
    </div>
</x-layouts.app >