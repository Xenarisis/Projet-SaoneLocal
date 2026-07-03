<x-layouts.app title="Mon Panier">
    

    <div class="container mx-auto p-4 lg:p-8 max-w-5xl" x-data="cart()">
        
        <div class="flex flex-col items-center justify-center mb-10 relative">
            <div class="flex items-center gap-3 relative z-10 mt-6">
                <div class="w-10 h-10 lg:w-12 lg:h-12 text-base-green shrink-0">
                    <x-icon name="basket" class="w-full h-full" />
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-[#1B1B18]">Mon Panier</h1>
            </div>
            
            <div class="w-full max-w-xl mt-2 relative">
                <x-icon name="branch_alt" class="w-full h-auto [&_path[stroke='#008156']]:fill-[#009A66]" />
                
                <div class="absolute inset-0 pointer-events-none overflow-hidden">
                    <div class="firefly-float absolute top-1/4 left-1/4" style="animation-delay: 0s;">
                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-[#fef08a] rounded-full firefly-twinkle shadow-[0_0_8px_#fef08a]" style="animation-delay: 0s;"></div>
                    </div>
                    <div class="firefly-float absolute top-1/2 left-2/3" style="animation-delay: -2s;">
                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-[#fde047] rounded-full firefly-twinkle shadow-[0_0_8px_#fde047]" style="animation-delay: 0.8s;"></div>
                    </div>
                    <div class="firefly-float absolute top-3/4 left-1/2" style="animation-delay: -4s;">
                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-[#fef08a] rounded-full firefly-twinkle shadow-[0_0_8px_#fef08a]" style="animation-delay: 1.5s;"></div>
                    </div>
                    <div class="firefly-float absolute top-1/3 left-3/4" style="animation-delay: -1s;">
                        <div class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-[#fde047] rounded-full firefly-twinkle shadow-[0_0_10px_#fde047]" style="animation-delay: 0.5s;"></div>
                    </div>
                    <div class="firefly-float absolute top-2/3 left-1/4" style="animation-delay: -3s;">
                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-[#fef08a] rounded-full firefly-twinkle shadow-[0_0_8px_#fef08a]" style="animation-delay: 1.2s;"></div>
                    </div>
                    <div class="firefly-float absolute top-[15%] left-1/2" style="animation-delay: -5s;">
                        <div class="w-1 h-1 sm:w-1.5 sm:h-1.5 bg-[#fde047] rounded-full firefly-twinkle shadow-[0_0_6px_#fde047]" style="animation-delay: 0.3s;"></div>
                    </div>
                    <div class="firefly-float absolute top-[85%] left-[80%]" style="animation-delay: -1.5s;">
                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-[#fef08a] rounded-full firefly-twinkle shadow-[0_0_8px_#fef08a]" style="animation-delay: 1.8s;"></div>
                    </div>
                </div>
            </div>
        </div>

        <template x-if="loading">
            <div class="flex flex-col justify-center items-center py-20 gap-4">
                <div class="w-12 h-12 border-4 border-base-green border-t-transparent rounded-full animate-spin"></div>
                <p class="text-base-gray font-medium text-lg">Chargement de votre panier...</p>
            </div>
        </template>

        <template x-if="!loading && items.length === 0">
            <div class="bg-stone-50 rounded-3xl p-12 shadow-sm border border-[#e3e3e0] text-center flex flex-col items-center">
                <div class="w-24 h-24 text-gray-300 mb-6">
                    <x-icon name="basket" class="w-full h-full" />
                </div>
                <h2 class="text-2xl font-bold text-[#1B1B18] mb-2">Votre panier est vide</h2>
                <p class="text-lg text-base-gray mb-8">On dirait que vous n'avez pas encore trouvé votre bonheur.</p>
                <a href="{{ route('home') }}" class="inline-block bg-base-green text-white font-bold text-lg py-4 px-10 rounded-full hover:bg-pine-green transition-transform hover:scale-105 shadow-md">
                    Découvrir nos produits
                </a>
            </div>
        </template>

        <template x-if="!loading && items.length > 0">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3 flex flex-col gap-6">
                    <template x-for="item in items" :key="item.id">
                        <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-sm border border-[#e3e3e0] flex flex-col sm:flex-row items-start sm:items-center gap-5 hover:shadow-md transition-shadow relative overflow-hidden group">
                            
                            <!-- Leaf accent in the corner -->
                            <div class="absolute -top-6 -right-6 text-base-green/10 w-24 h-24 transform rotate-45 group-hover:scale-110 transition-transform duration-500 pointer-events-none">
                                <x-icon name="leaf" class="w-full h-full" />
                            </div>

                            <a :href="'/products/' + item.product.id" class="w-full sm:w-28 h-48 sm:h-28 shrink-0 bg-gray-100 rounded-2xl overflow-hidden border border-gray-100 relative shadow-inner block group/img">
                                <img :src="item.product.image_path ? (item.product.image_path.startsWith('http') ? item.product.image_path : (item.product.image_path.startsWith('/') ? item.product.image_path : '/' + item.product.image_path)) : '{{ asset('images/product.svg') }}'" x-on:error="$el.src = '{{ asset('images/product.svg') }}'" alt="Produit" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl group-hover/img:bg-black/5 transition-colors"></div>
                            </a>

                            <div class="flex-1 min-w-0 flex flex-col justify-center relative z-10">
                                <a :href="'/products/' + item.product.id" class="block group/title">
                                    <h3 class="text-xl sm:text-2xl font-bold text-[#1B1B18] mb-1 group-hover/title:text-base-green transition-colors truncate" x-text="item.product.name" :title="item.product.name"></h3>
                                </a>
                                <p class="text-base-green font-medium" x-text="formatPrice(item.product.price) + '\u00A0€ / unité'"></p>
                            </div>

                            <div class="flex items-center gap-2 bg-stone-50 p-1.5 rounded-2xl border border-gray-200 shrink-0 relative z-10 shadow-sm">
                                <button @click="updateQuantity(item.id, item.quantity - 1)" :disabled="item.updating" class="hover:bg-white hover:shadow-sm w-10 h-10 rounded-xl font-bold text-xl flex items-center justify-center transition-all text-gray-700 disabled:opacity-50 disabled:hover:bg-transparent">-</button>
                                <span class="w-8 text-center font-bold text-lg text-[#1B1B18]" x-text="item.quantity"></span>
                                <button @click="updateQuantity(item.id, item.quantity + 1)" :disabled="item.updating || item.quantity >= item.product.quantity" class="hover:bg-white hover:shadow-sm w-10 h-10 rounded-xl font-bold text-xl flex items-center justify-center transition-all text-gray-700 disabled:opacity-50 disabled:hover:bg-transparent">+</button>
                            </div>

                            <div class="w-full sm:w-auto mt-2 sm:mt-0 flex items-center justify-between sm:justify-end gap-4 sm:gap-6 relative z-10">
                                <div class="flex flex-col items-end">
                                    <span class="font-black text-2xl sm:text-3xl text-[#1B1B18] whitespace-nowrap" x-text="formatPrice(item.product.price * item.quantity) + '\u00A0€'"></span>
                                </div>

                                <button @click="$dispatch('remove-item', item.id)" class="text-red-blood bg-red-50 hover:bg-error hover:text-white w-12 h-12 flex items-center justify-center rounded-2xl transition-all shadow-sm shrink-0 sm:ml-2" title="Retirer du panier">
                                    <x-icon name="bin" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="lg:w-1/3 relative">
                    <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-md border border-base-green/20 sticky top-32 overflow-hidden">
                        
                        <h3 class="text-2xl font-bold mb-6 text-[#1B1B18] flex items-center gap-3 relative z-10">
                            <div class="w-8 h-8 text-base-green"><x-icon name="basket" class="w-full h-full"/></div>
                            Récapitulatif
                        </h3>
                        
                        <div class="space-y-4 relative z-10">
                            <div class="flex justify-between text-gray-600 font-medium">
                                <span>Sous-total HT</span>
                                <span class="whitespace-nowrap" x-text="formatPrice(totalExclTax) + '\u00A0€'"></span>
                            </div>
                            
                            <div class="flex justify-between text-gray-600 font-medium">
                                <span>TVA (20%)</span>
                                <span class="whitespace-nowrap" x-text="formatPrice(totalExclTax * 0.20) + '\u00A0€'"></span>
                            </div>
                            
                            <div class="h-px w-full bg-gradient-to-r from-transparent via-gray-300 to-transparent my-2"></div>

                            <div class="bg-base-green/5 rounded-2xl p-5 border border-base-green/20 overflow-hidden">
                                <div class="flex flex-wrap justify-between items-end text-[#1B1B18] gap-x-2 gap-y-1">
                                    <span class="font-bold text-lg sm:text-xl">Total TTC</span>
                                    <span class="text-3xl sm:text-4xl font-black text-base-green whitespace-nowrap" x-text="formatPrice(totalExclTax * 1.20) + '\u00A0€'"></span>
                                </div>
                                <span class="mt-4 flex items-center justify-center gap-2 text-xs sm:text-sm text-gray-600 bg-white/60 p-2 rounded-xl">
                                    <x-icon name="check" class="w-4 h-4 text-base-green shrink-0" />
                                    Paiement à la récupération
                                </span>
                            </div>
                        </div>

                        <button @click="checkout" :disabled="checkingOut" class="w-full bg-base-green text-white font-bold text-lg py-4 mt-6 rounded-2xl hover:bg-pine-green hover:shadow-lg hover:-translate-y-0.5 disabled:opacity-70 disabled:hover:shadow-none disabled:transform-none transition-all flex justify-center items-center gap-3 relative z-10">
                            <span x-show="!checkingOut">Valider ma commande</span>
                            <span x-show="checkingOut" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Validation...
                            </span>
                        </button>
                        
                        <div class="mt-5 flex items-center justify-center gap-2 text-xs sm:text-sm text-gray-500 relative z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Paiement sécurisé et garanti
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    
</x-layouts.app>
