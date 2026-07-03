<x-layouts.app title="Mes Commandes">
    <div class="container mx-auto p-4 max-w-4xl" x-data="orders()">
        <h1 class="text-3xl font-bold mb-6 text-[#1B1B18] text-center lg:text-left">Historique de mes commandes</h1>

        <template x-if="loading">
            <div class="flex justify-center items-center py-12">
                <p class="text-[#706f6c] text-xl">Chargement de vos commandes...</p>
            </div>
        </template>

        <template x-if="!loading && items.length === 0">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-[#e3e3e0] text-center">
                <p class="text-xl text-[#706f6c] mb-6">Vous n'avez passé aucune commande pour le moment.</p>
                <a href="{{ route('home') }}" class="inline-block bg-red-blood text-white font-bold py-4 px-10 text-lg rounded-full hover:opacity-80 transition-colors shadow-md">
                    Faire des achats
                </a>
            </div>
        </template>

        <template x-if="!loading && items.length > 0">
            <div class="flex flex-col gap-6">
                <template x-for="order in items" :key="order.id">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#e3e3e0]">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 pb-4 border-b border-[#e3e3e0]">
                            <div>
                                <h3 class="text-lg font-bold text-[#1B1B18]" x-text="'Commande ' + order.order_number"></h3>
                                <p class="text-sm text-[#706f6c]" x-text="'Passée le ' + formatDate(order.created_at)"></p>
                            </div>
                            
                            <div class="mt-4 md:mt-0 flex flex-col md:items-end">
                                <p class="text-xl font-bold text-[#1B1B18]" x-text="formatPrice(order.total_excl_tax * (1 + order.percentage_tax/100)) + ' €'"></p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold" 
                                        :class="{
                                            'bg-yellow-100 text-yellow-800': computedOrderStatus(order) === 'pending',
                                            'bg-blue-100 text-blue-800': computedOrderStatus(order) === 'processing',
                                            'bg-green-100 text-green-800': computedOrderStatus(order) === 'ready' || computedOrderStatus(order) === 'completed',
                                            'bg-red-100 text-red-800': computedOrderStatus(order) === 'cancelled'
                                        }"
                                        x-text="translateStatus(computedOrderStatus(order))">
                                    </span>
                                    <button 
                                        x-show="order.status === 'pending'" 
                                        @click="cancelOrder(order.id)" 
                                        class="text-xs font-bold text-red-blood hover:opacity-70 underline transition-opacity"
                                    >
                                        Annuler la commande
                                    </button>
                                </div>
                                
                                <p x-show="order.payment_status === 'counter' && order.status !== 'completed' && order.status !== 'cancelled'" class="text-sm font-semibold text-yellow-600 mt-3 flex items-center gap-1 bg-yellow-50 px-3 py-1 rounded-full border border-yellow-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Paiement en attente au comptoir
                                </p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="font-bold text-sm text-[#706f6c] mb-3 uppercase tracking-wider">Articles</h4>
                            <div class="flex flex-col gap-2">
                                <template x-for="item in order.items" :key="item.id">
                                    <div class="flex flex-col text-sm border-b border-gray-200 last:border-0 pb-3 mb-3 last:pb-0 last:mb-0">
                                        <div class="flex justify-between items-start sm:items-center gap-4">
                                            <div class="flex flex-wrap sm:flex-nowrap gap-2 sm:gap-3 items-center flex-1">
                                                <span class="font-semibold text-[#1B1B18]" x-text="item.quantity + 'x'"></span>
                                                <span class="text-[#706f6c] truncate" x-text="item.product_name"></span>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shrink-0" 
                                                    :class="{
                                                        'bg-gray-100 text-gray-600': item.status === 'nouvelle',
                                                        'bg-yellow-100 text-yellow-800': item.status === 'en préparation',
                                                        'bg-green-100 text-green-800': item.status === 'prête',
                                                        'bg-blue-100 text-blue-800': item.status === 'retirée',
                                                        'bg-red-100 text-red-800': item.status === 'annulée'
                                                    }"
                                                    x-text="translateItemStatus(item.status)">
                                                </span>
                                            </div>
                                            <span class="text-[#1B1B18] font-bold text-base whitespace-nowrap shrink-0" x-text="formatPrice(item.unit_price * item.quantity) + ' €'"></span>
                                        </div>
                                        
                                        <template x-if="item.pickup_date || item.pickup_location || item.pickup_time">
                                            <div class="mt-2 text-xs text-cachou bg-orange-50 p-2 rounded-md border border-orange-100 flex flex-col gap-1">
                                                <div class="font-bold flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                    </svg>
                                                    Retrait prévu :
                                                </div>
                                                <div x-show="item.pickup_date" class="ml-4" x-text="'📅 ' + new Date(item.pickup_date).toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long' })"></div>
                                                <div x-show="item.pickup_time" class="ml-4" x-text="'🕒 ' + item.pickup_time"></div>
                                                <div x-show="item.pickup_location" class="ml-4" x-text="'📍 ' + item.pickup_location"></div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    
</x-layouts.app>
