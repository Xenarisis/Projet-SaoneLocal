<x-layouts.app title="Tableau de bord Producteur">
    <div class="w-full max-w-2xl mx-auto pb-24" x-data="producerDashboard()" x-init="init()">
        
        <h1 class="text-center text-4xl font-black italic mb-8" x-text="stats.producer_name || 'Producteur'"></h1>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl" x-text="activeTab === 'products' ? 'Mes produits' : 'Mes commandes'"></h2>
            <template x-if="activeTab === 'products'">
                <a href="{{ route('producer.products.create') }}" class="px-4 py-1.5 border border-black rounded-full text-sm font-medium hover:bg-gray-100 transition-colors">
                    + Ajouter un produit
                </a>
            </template>
        </div>

        <div class="flex gap-4 mb-8">
            <button @click="activeTab = 'products'" 
                :class="activeTab === 'products' ? 'bg-cachou text-white border-cachou' : 'bg-transparent border-black text-black'" 
                class="px-6 py-1.5 rounded-full border font-medium transition-colors">
                Catalogue
            </button>
            <button @click="activeTab = 'orders'" 
                :class="activeTab === 'orders' ? 'bg-cachou text-white border-cachou' : 'bg-transparent border-black text-black'" 
                class="px-6 py-1.5 rounded-full border font-medium transition-colors flex items-center gap-1">
                Commandes
                <span x-cloak x-show="stats.new_orders_count > 0" x-transition x-text="stats.new_orders_count" class="bg-yellow-400 text-black text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none"></span>
            </button>
            <button @click="activeTab = 'finances'" 
                :class="activeTab === 'finances' ? 'bg-cachou text-white border-cachou' : 'bg-transparent border-black text-black'" 
                class="px-6 py-1.5 rounded-full border font-medium transition-colors">
                Finances
            </button>
        </div>

        <div x-show="loading" class="flex justify-center items-center py-20">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-t-2 border-cachou"></div>
        </div>

        <x-producers.products-tab />

        <x-producers.orders-tab />

        <x-producers.finances-tab />

        <x-producers.accept-order-modal />

    </div>
</x-layouts.app>
