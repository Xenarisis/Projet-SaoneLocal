<x-layouts.app title="search">

<div x-data="{
    openFilters: false,
    search: '{{ request('q') }}',
    category: '',
    min_price: '',
    max_price: '',
    products: [],
    producers: [],
    loading: false,

    init() {
        this.fetchResults();
    },

    async fetchResults() {
        this.loading = true;
        const params = new URLSearchParams();
        if (this.search) params.append('name', this.search);
        if (this.category) params.append('category', this.category);
        if (this.min_price) params.append('min_price', this.min_price);
        if (this.max_price) params.append('max_price', this.max_price);

        {{-- Les deux en parallèle --}}
        const [resProducts, resProducers] = await Promise.all([
            fetch(`/api/products?${params}`),
            fetch(`/api/producers?${params}`)
        ]);

        const dataProducts = await resProducts.json();
        const dataProducers = await resProducers.json();

        this.products = dataProducts.data;
        this.producers = dataProducers.data;
        this.loading = false;
    },

    applyFilters() {
        this.fetchResults();
        this.openFilters = false;
    }
}">

    {{-- Barre du haut --}}
    <div class="flex items-center gap-2 mb-2">
        <button 
            @click="openFilters = !openFilters"
            class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full text-white"
        >
            {!! file_get_contents(public_path('images/filter.svg')) !!}
        </button>
        <input 
            type="search"
            x-model="search"
            @input.debounce.300ms="fetchResults()"
            placeholder="Rechercher..."
            class="flex-1 rounded-full border outline-none p-2 px-4"
        >
    </div>

    {{-- Panneau filtres --}}
    <div 
        x-show="openFilters"
        x-transition
        @click.outside="openFilters = false"
        class="bg-white rounded-2xl shadow-lg p-4 mb-4 flex flex-col gap-3"
    >
        <div>
            <label class="text-sm font-medium text-gray-600">Catégorie</label>
            <select x-model="category" class="w-full mt-1 rounded-full px-4 py-2 border outline-none">
                <option value="">Toutes</option>
                <option value="fruits">Fruits</option>
                <option value="legumes">Légumes</option>
                <option value="vins">Vins</option>
            </select>
        </div>

        <div class="flex gap-2">
            <div class="flex-1">
                <label class="text-sm font-medium text-gray-600">Prix min (€)</label>
                <input type="number" x-model="min_price" placeholder="0"
                    class="w-full mt-1 rounded-full px-4 py-2 border outline-none">
            </div>
            <div class="flex-1">
                <label class="text-sm font-medium text-gray-600">Prix max (€)</label>
                <input type="number" x-model="max_price" placeholder="100"
                    class="w-full mt-1 rounded-full px-4 py-2 border outline-none">
            </div>
        </div>

        <div class="flex gap-2">
            <button 
                @click="category = ''; min_price = ''; max_price = ''; fetchResults()"
                class="flex-1 rounded-full border py-2 text-sm text-gray-600 hover:bg-gray-100"
            >
                Réinitialiser
            </button>
            <button 
                @click="applyFilters()"
                class="flex-1 rounded-full bg-[#820606] text-white py-2 text-sm"
            >
                Appliquer
            </button>
        </div>
    </div>

    {{-- Loading --}}
    <div x-show="loading" class="text-center text-gray-500 py-4">Chargement...</div>

    <div x-show="!loading">

        {{-- Section produits --}}
        <h1 class="w-full font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl mb-3">
            Nos produits
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <template x-for="product in products" :key="product.id">
                <a :href="'/products/' + product.id" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img :src="'/storage/products/' + product.image_path" :alt="product.name" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 x-text="product.name" class="font-bold text-lg"></h2>
                        <p x-text="product.price + ' €'" class="text-[#820606] font-bold mt-1"></p>
                    </div>
                </a>
            </template>
            <p x-show="products.length === 0" class="col-span-3 text-center text-gray-500">Aucun produit trouvé.</p>
        </div>

        {{-- Section producteurs --}}
        <h1 class="w-full font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-2 text-2xl mb-3">
            Nos producteurs
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template x-for="producer in producers" :key="producer.id">
                <a :href="'/producer/' + producer.id" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <img :src=" asset(producer.user?.pdp_path)" :alt="producer.name" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 x-text="producer.name" class="font-bold text-lg"></h2>
                        <p x-text="producer.city" class="text-gray-500 text-sm mt-1"></p>
                    </div>
                </a>
            </template>
            <p x-show="producers.length === 0" class="col-span-3 text-center text-gray-500">Aucun producteur trouvé.</p>
        </div>

    </div>

</div>
</x-layouts.app >