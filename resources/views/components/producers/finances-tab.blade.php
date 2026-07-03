<div x-show="!loading && activeTab === 'finances'" x-cloak class="space-y-8">
    <h1 class="font-bold rounded-2xl bg-base-green text-base-gray text-center p-2 text-2xl mb-6 font-title">Vos Statistiques</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-cachou text-white border border-black rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col">
            <h2 class="font-bold text-lg leading-tight uppercase tracking-widest text-white">Chiffre d'affaires</h2>
            <p class="text-sm text-white/70 mt-1 mb-4">Sur les commandes non annulées</p>
            <div class="mt-auto pt-3 border-t border-black text-center">
                <span class="font-title text-4xl text-base-green" x-text="stats.total_sales.toFixed(2) + ' €'"></span>
            </div>
        </div>

        <div class="bg-cachou text-white border border-black rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col">
            <h2 class="font-bold text-lg leading-tight uppercase tracking-widest text-white">Clients Uniques</h2>
            <p class="text-sm text-white/70 mt-1 mb-4">Personnes distinctes ayant commandé</p>
            <div class="mt-auto pt-3 border-t border-black text-center">
                <span class="font-title text-4xl text-white" x-text="stats.distinct_clients"></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1 bg-cachou text-white border border-black rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col">
            <h2 class="font-bold text-lg leading-tight uppercase tracking-widest text-white">Panier Moyen</h2>
            <p class="text-sm text-white/70 mt-1 mb-4">Par commande passée</p>
            <div class="mt-auto pt-3 border-t border-black text-center">
                <span class="font-title text-3xl text-white" x-text="stats.average_cart.toFixed(2) + ' €'"></span>
            </div>
        </div>
        <div class="col-span-1 md:col-span-2 bg-base-green border border-black rounded-2xl p-6 shadow-sm hover:shadow-md transition text-base-gray flex flex-col">
            <h2 class="font-bold text-lg leading-tight uppercase tracking-widest text-white">Produit Best-Seller 🌟</h2>
            <p class="text-sm text-base-gray/70 mt-1 mb-4">Le produit qui plaît le plus</p>
            <div class="mt-auto pt-3 border-t border-black flex flex-col sm:flex-row justify-between items-center gap-4">
                <span class="font-title text-3xl text-white break-words text-center sm:text-left" x-text="stats.best_selling_product_name"></span>
                <span class="font-bold bg-white text-base-green px-4 py-2 rounded-xl text-lg whitespace-nowrap"><span x-text="stats.best_selling_product_qty"></span> vendus</span>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h1 class="font-bold rounded-2xl bg-base-green text-base-gray text-center p-2 text-2xl mb-6 font-title">Volume & Statuts</h1>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            
            <div class="bg-cachou text-white border border-black rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-sm uppercase tracking-wide text-white">Volume Total</h2>
                    <p class="text-xs text-white/70 mt-1">Produits vendus</p>
                </div>
                <div class="mt-3 pt-3 border-t border-black">
                    <span class="font-title text-3xl text-white" x-text="stats.total_items_sold"></span>
                </div>
            </div>
            
            <div class="bg-[#F8B803]/20 border border-black rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-sm uppercase tracking-wide text-dark">En Cours</h2>
                    <p class="text-xs text-gray-600 mt-1">Nouvelles & Prépa</p>
                </div>
                <div class="mt-3 pt-3 border-t border-black">
                    <span class="font-title text-3xl text-dark" x-text="stats.orders_in_progress"></span>
                </div>
            </div>
            
            <div class="bg-base-green/20 border border-black rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-sm uppercase tracking-wide text-dark">Abouties</h2>
                    <p class="text-xs text-gray-600 mt-1">Prêtes & Retirées</p>
                </div>
                <div class="mt-3 pt-3 border-t border-black">
                    <span class="font-title text-3xl text-base-green" x-text="stats.orders_completed"></span>
                </div>
            </div>
            
            <div class="bg-red-100 border border-black rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center flex flex-col justify-between">
                <div>
                    <h2 class="font-bold text-sm uppercase tracking-wide text-dark">Annulées</h2>
                    <p class="text-xs text-red-600 mt-1">Refusées</p>
                </div>
                <div class="mt-3 pt-3 border-t border-black">
                    <span class="font-title text-3xl text-red-600" x-text="stats.orders_cancelled"></span>
                </div>
            </div>
        </div>
    </div>
</div>
