<div x-show="!loading && activeTab === 'orders'" x-cloak class="space-y-6">
    <div class="flex flex-wrap gap-2 text-sm mb-6 pb-2 border-b border-gray-400">
        <button @click="fetchOrders('toutes')" :class="orderFilter === 'toutes' ? 'font-bold text-black' : 'text-gray-600'" class="hover:text-black flex items-center gap-1">
            Toutes
            <span x-show="stats.new_orders_count > 0" x-text="stats.new_orders_count" class="bg-yellow-400 text-black text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none"></span>
        </button>
        <span class="text-gray-400">|</span>
        <button @click="fetchOrders('nouvelle')" :class="orderFilter === 'nouvelle' ? 'font-bold text-black' : 'text-gray-600'" class="hover:text-black flex items-center gap-1">
            Nouvelles
            <span x-show="stats.new_orders_count > 0" x-text="stats.new_orders_count" class="bg-yellow-400 text-black text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none"></span>
        </button>
        <span class="text-gray-400">|</span>
        <button @click="fetchOrders('en préparation')" :class="orderFilter === 'en préparation' ? 'font-bold text-black' : 'text-gray-600'" class="hover:text-black">En préparation</button>
        <span class="text-gray-400">|</span>
        <button @click="fetchOrders('prête')" :class="orderFilter === 'prête' ? 'font-bold text-black' : 'text-gray-600'" class="hover:text-black">Prête</button>
        <span class="text-gray-400">|</span>
        <button @click="fetchOrders('retirée')" :class="orderFilter === 'retirée' ? 'font-bold text-black' : 'text-gray-600'" class="hover:text-black">Retirée</button>
    </div>

    <template x-for="item in orders" :key="item.id">
        <x-producers.order-card />
    </template>
    <div x-show="orders.length === 0" class="text-center py-12 text-gray-500 italic">
        Aucune commande trouvée pour ce filtre.
    </div>
</div>
