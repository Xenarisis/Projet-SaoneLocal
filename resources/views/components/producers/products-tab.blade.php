<div x-show="!loading && activeTab === 'products'" x-cloak class="space-y-6">
    <template x-for="product in products" :key="product.id">
        <x-producers.product-card />
    </template>
    <div x-show="products.length === 0" class="text-center py-12 text-gray-500 italic">
        Aucun produit dans votre catalogue.
    </div>
</div>
