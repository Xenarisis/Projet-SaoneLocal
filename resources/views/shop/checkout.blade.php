<x-layouts.app title="Paiement">
    <div class="min-h-screen flex flex-col items-center p-4 pt-10 font-body" x-data="checkout()">
        <form id="checkoutForm" @submit.prevent="processPayment('card')"
            class="bg-base-green w-full max-w-2xl rounded-2xl sm:rounded-[32px] shadow-2xl p-6 sm:p-10 flex flex-col items-center relative">
            
            <div class="mb-8 mt-2 flex flex-col gap-4 w-full items-center">
                <h1 class="text-white text-center font-bold text-3xl sm:text-4xl italic tracking-wide">
                    Paiement sécurisé
                </h1>

                <p class="text-white text-center mt-2 font-bold text-xl bg-white/20 px-6 py-3 rounded-full">
                    Total : <span x-text="formatPrice(total) + ' €'"></span>
                </p>
            </div>

            <div class="w-full flex flex-col gap-6">
                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Numéro de carte</span>
                    <x-icon-pill-input
                        type="text"
                        name="card_number"
                        required
                        placeholder="0000 0000 0000 0000"
                        value="4242 4242 4242 4242"
                        :asterisk="false"
                    />
                </div>

                <div class="flex flex-col sm:flex-row gap-6 w-full">
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Date d'expiration</span>
                        <x-icon-pill-input
                            type="text"
                            name="expiry"
                            required
                            placeholder="MM/AA"
                            value="12/30"
                            :asterisk="false"
                        />
                    </div>
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Code CVC</span>
                        <x-icon-pill-input
                            type="text"
                            name="cvc"
                            required
                            placeholder="123"
                            value="123"
                            :asterisk="false"
                        />
                    </div>
                </div>

                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Nom sur la carte</span>
                    <x-icon-pill-input
                        type="text"
                        name="card_name"
                        required
                        placeholder="Jean Dupont"
                        value="Saône Local"
                        :asterisk="false"
                    />
                </div>

                <div class="mt-8 flex flex-col items-center gap-4 w-full">
                    <x-pill-button type="submit" x-bind:disabled="processing">
                        <div class="flex items-center gap-2 text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <span x-show="!processing">Payer et finaliser</span>
                            <span x-show="processing" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Traitement...
                            </span>
                        </div>
                    </x-pill-button>
                    
                    <button type="button" @click="processPayment('counter')" x-bind:disabled="processing" class="text-white cursor-pointer hover:text-gray-200 underline text-sm font-semibold transition-colors disabled:opacity-50">
                        Je souhaite payer au près du commerçant
                    </button>
                </div>
            </div>
        </form>
    </div>

    
</x-layouts.app>
