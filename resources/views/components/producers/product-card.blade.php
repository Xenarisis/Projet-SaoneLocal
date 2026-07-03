<div class="bg-stone-50 text-dark rounded-3xl p-6 flex flex-col md:flex-row gap-4 shadow-sm border border-[#e3e3e0] relative transition-shadow hover:shadow-md">
    <div class="w-32 h-40 md:w-40 md:h-48 shrink-0 bg-white rounded-2xl border border-gray-200 overflow-hidden flex items-center justify-center">
        <img :src="product.image_url || '{{ asset('images/product.svg') }}'" x-on:error="$el.src = '{{ asset('images/product.svg') }}'" alt="Produit" class="w-full h-full object-cover">
    </div>
    
    <div class="flex-1 flex flex-col justify-between h-full">
        <div class="pr-16">
            <h3 class="text-xl font-bold leading-tight mb-1 text-[#1B1B18]" x-text="product.name"></h3>
            <p class="text-sm font-medium text-base-gray mb-3" x-text="product.category"></p>
            <p class="text-sm text-[#706f6c] line-clamp-3 mb-2" x-text="product.description || 'Aucune description fournie.'"></p>
            <div class="text-sm text-[#706f6c] font-medium mt-1">
                Quantité disponible : <span class="font-bold text-[#1B1B18]" x-text="product.quantity"></span>
            </div>
        </div>
        
        <div class="flex justify-end gap-3 mt-4 md:mt-0">
            <a :href="'/producer/products/' + product.id + '/edit'" class="px-5 py-2 text-sm font-medium border border-[#e3e3e0] bg-white text-[#1B1B18] rounded-full hover:bg-gray-50 transition-colors shadow-sm">Modifier</a>
            <button @click.prevent="deleteProduct(product.id)" class="px-5 py-2 text-sm font-medium border border-[#e3e3e0] bg-white text-red-blood rounded-full hover:bg-red-50 transition-colors shadow-sm">Supprimer</button>
        </div>
    </div>
    
    <div class="absolute top-6 right-6">
        <span class="text-xl font-bold text-base-green" x-text="product.price + '€'"></span>
    </div>
</div>
