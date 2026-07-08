<x-layouts.app title="Gérer le produit">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 font-body pt-24 pb-12" x-data="productForm()" x-init="init()">
        
        <div x-show="loading" class="flex justify-center items-center py-10 mb-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-t-2 border-base-green"></div>
        </div>

        <form @submit.prevent="saveProduct" x-show="!loading" x-cloak 
            class="bg-base-green w-full max-w-4xl rounded-2xl sm:rounded-[32px] shadow-2xl p-6 sm:p-10 flex flex-col items-center relative">
            
            <div class="mb-10 flex flex-col gap-2 w-full items-center">
                <h1 class="text-white text-center font-bold text-3xl sm:text-4xl tracking-wide" x-text="productId ? 'Modifier le produit' : 'Nouveau produit'"></h1>
                
                <div class="h-px w-full max-w-sm bg-gradient-to-r from-transparent via-white to-transparent my-4"></div>
                
                <p class="text-sm text-white text-center">Les champs marqués d'un astérisque sont obligatoires.</p>
            </div>
            
            <div class="mb-8 flex justify-center w-full">
                <x-avatar-cropper alpineImage="form.image_url" inputId="product_image" inputName="image" @avatar-changed="form.image = $event.detail.file; form.image_url = $event.detail.preview" @avatar-deleted="form.image = null; form.image_url = null; form.delete_image = 1" />
            </div>

            <div class="w-full flex flex-col gap-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full">
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Nom du produit</span>
                        <x-icon-pill-input
                            type="text"
                            x-model="form.name"
                            required
                            placeholder="Nom du produit"
                            :asterisk="true"
                        />
                    </div>
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Catégorie</span>
                        <x-icon-pill-input
                            type="text"
                            x-model="form.category"
                            placeholder="Ex: Légumes, Viandes..."
                            icon="images/filter.svg"
                        />
                    </div>
                </div>

                <div class="flex flex-col gap-1.5 w-full">
                    <span class="text-white ml-2 text-sm font-semibold tracking-wide">Description</span>
                    <label class="relative w-full flex items-center px-6 py-3 border-2 border-white focus-within:border-info rounded-[32px] bg-transparent hover:bg-white/20 transition-all duration-200">
                        <textarea x-model="form.description" rows="3" class="flex-1 min-w-0 bg-transparent text-white placeholder:text-white/90 placeholder:font-normal antialiased outline-none text-base font-medium tracking-wide focus:ring-0 border-none p-0 resize-none" placeholder="Description de votre produit..."></textarea>
                    </label>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 w-full">
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Prix (€)</span>
                        <x-icon-pill-input
                            type="number"
                            step="0.01"
                            x-model="form.price"
                            required
                            placeholder="Ex: 5.50"
                            :asterisk="true"
                        />
                    </div>
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Prix unitaire (au...)</span>
                        <x-icon-pill-input
                            type="text"
                            x-model="form.unit"
                            placeholder="kg, pièce, litre..."
                        />
                    </div>
                    <div class="flex flex-col gap-1.5 w-full">
                        <span class="text-white ml-2 text-sm font-semibold tracking-wide">Quantité (Stock)</span>
                        <x-icon-pill-input
                            type="number"
                            x-model="form.quantity"
                            required
                            placeholder="Stock disponible"
                            icon="images/basket.svg"
                            :asterisk="true"
                        />
                    </div>
                </div>

                <div class="mt-8 flex justify-center items-center w-full gap-6">
                    <a href="{{ route('producer.dashboard') }}" class="px-6 py-3 text-white bg-transparent border border-white rounded-full hover:bg-white/20 transition-all duration-200 text-sm font-bold tracking-wide focus:outline-none">
                        Annuler
                    </a>
                    <x-pill-button type="submit" x-bind:disabled="saving">
                        <span x-show="!saving" x-text="productId ? 'Enregistrer' : 'Créer le produit'"></span>
                        <span x-show="saving">Traitement en cours...</span>
                    </x-pill-button>
                </div>
            </div>
        </form>
    </div>

    
</x-layouts.app>
