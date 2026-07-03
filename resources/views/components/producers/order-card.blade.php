<div class="relative rounded-[27px] transition-shadow hover:shadow-md" :class="item.status === 'nouvelle' ? 'p-[3px] overflow-hidden shadow-lg' : 'shadow-sm'">
    <div x-show="item.status === 'nouvelle'" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200%] aspect-square animate-[spin_3s_linear_infinite]" style="background: conic-gradient(from 0deg, transparent 0%, #F8B803 50%, transparent 100%); z-index: 0;"></div>
    
    <div :class="item.status === 'nouvelle' ? 'border-transparent' : 'border border-[#e3e3e0]'" class="relative z-10 bg-stone-50 text-dark rounded-3xl p-6 flex flex-col gap-6 justify-between h-full">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200 pb-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold uppercase shadow-inner" x-text="(item.order && item.order.user && item.order.user.firstname ? item.order.user.firstname.charAt(0) : '?')"></div>
                <div>
                    <div class="font-bold text-lg text-[#1B1B18]" x-text="(item.order && item.order.user ? item.order.user.firstname + ' ' + item.order.user.lastname : 'Client Inconnu')"></div>
                    <div class="text-xs text-gray-500 font-medium" x-text="'Commande N° ' + item.id"></div>
                </div>
            </div>
            <div class="text-sm text-[#706f6c] font-medium bg-white px-4 py-1.5 rounded-full border border-gray-200 shadow-sm" x-text="'Le ' + new Date(item.created_at).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-5">
            <div class="flex-1 bg-white rounded-2xl px-7 py-6 border border-gray-100 shadow-sm flex flex-col justify-center">
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-2">Produit commandé</div>
                <div class="font-black text-xl text-cachou break-words" x-text="item.quantity + ' x ' + item.product_name"></div>
            </div>

            <template x-if="item.pickup_date || item.pickup_time || item.pickup_location">
                <div class="flex-1 bg-orange-50/50 rounded-2xl p-6 md:p-8 border border-orange-100 shadow-sm text-sm">
                    <div class="text-[11px] text-orange-800/70 font-bold uppercase tracking-widest mb-4">Détails du retrait</div>
                    <div class="space-y-3 text-orange-900">
                        <div x-show="item.pickup_date" class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-semibold text-base" x-text="new Date(item.pickup_date).toLocaleDateString('fr-FR', { weekday: 'long', day: 'numeric', month: 'long' })"></span>
                        </div>
                        <div x-show="item.pickup_time" class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-semibold text-base" x-text="item.pickup_time"></span>
                        </div>
                        <div x-show="item.pickup_location" class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="font-semibold text-base break-words" x-text="item.pickup_location"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex flex-col md:flex-row justify-end items-end md:items-center gap-4 pt-2">
            <template x-if="item.status === 'nouvelle'">
                <button @click.stop="openAcceptModal(item)" class="px-8 py-3 bg-base-green text-white font-bold text-lg rounded-full hover:bg-pine-green transition-colors shadow-md hover:shadow-lg w-full md:w-auto">
                    Traiter la commande
                </button>
            </template>
            
            <template x-if="item.status !== 'nouvelle'">
                <div class="flex flex-col md:flex-row items-end md:items-center gap-6 w-full md:w-auto">
                    <button @click="updateOrderItem(item.id, 'annulée')" class="text-sm text-red-600 hover:text-red-800 font-medium underline underline-offset-2 transition-colors">
                        Annuler la commande
                    </button>
                    
                    <div class="flex flex-col items-start gap-1 w-full md:w-auto">
                        <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider px-2">Statut de la commande</label>
                        <div class="relative w-full md:w-56">
                            <select x-model="item.status" @change="updateOrderItem(item.id, item.status)" class="w-full px-5 py-2.5 border border-[#e3e3e0] rounded-full bg-white text-[#1B1B18] font-bold appearance-none hover:bg-gray-50 transition-colors cursor-pointer outline-none text-sm pr-10 shadow-sm focus:border-cachou focus:ring-1 focus:ring-cachou">
                                <option value="nouvelle" class="text-black">Nouvelle</option>
                                <option value="en préparation" class="text-black">En préparation</option>
                                <option value="prête" class="text-black">Prête</option>
                                <option value="retirée" class="text-black">Retirée</option>
                                <option value="annulée" class="text-black">Annulée</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
