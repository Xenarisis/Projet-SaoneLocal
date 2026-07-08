<x-layouts.app title="Mes Favoris">
    <div class="min-h-screen flex flex-col justify-start items-center p-4 font-body pt-8 pb-12 w-full">
        <h1 class="w-full font-bold rounded-2xl bg-[#057941] text-[#DEDEDE] text-center p-4 text-2xl lg:text-3xl mb-8 max-w-[1000px] shadow-md">Mes Favoris</h1>

        <div class="w-full max-w-[1000px]" x-data="{ favTab: 'products' }">
            <div class="flex justify-center gap-4 mb-8">
                <button @click="favTab = 'products'" :class="favTab === 'products' ? 'border-base-green text-base-green' : 'border-transparent text-gray-500 hover:text-base-green'" class="border-b-2 px-4 py-2 font-bold transition-colors">Produits (<span x-text="$store.favorites.dbBookmarksFull.length"></span>)</button>
                <button @click="favTab = 'producers'" :class="favTab === 'producers' ? 'border-base-green text-base-green' : 'border-transparent text-gray-500 hover:text-base-green'" class="border-b-2 px-4 py-2 font-bold transition-colors">Producteurs (<span x-text="$store.favorites.dbFollowsFull.length"></span>)</button>
            </div>

            <div x-show="favTab === 'products'">
                <template x-if="$store.favorites.dbBookmarksFull.length === 0">
                    <div class="bg-white rounded-2xl shadow-md p-8 text-center text-gray-500 italic">Aucun produit dans vos favoris.</div>
                </template>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <template x-for="bookmark in $store.favorites.dbBookmarksFull" :key="bookmark.id">
                        <div class="h-full">
                            <x-cards
                                ::title="bookmark.product.name"
                                ::href="`/products/${bookmark.product.id}`"
                                ::image="bookmark.product.image_path ? `/storage/products/${bookmark.product.image_path}` : '{{ asset('images/placeholder.png') }}'"
                                ::productId="bookmark.product.id"
                            >
                                <p class="text-[#820606] font-bold" x-text="bookmark.product.price + ' €'"></p>
                            </x-cards>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="favTab === 'producers'" x-cloak>
                <template x-if="$store.favorites.dbFollowsFull.length === 0">
                    <div class="bg-white rounded-2xl shadow-md p-8 text-center text-gray-500 italic">Vous ne suivez aucun producteur.</div>
                </template>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <template x-for="follow in $store.favorites.dbFollowsFull" :key="follow.id">
                        <div class="h-full">
                            <x-cards
                                ::title="follow.producer.name"
                                ::href="`/producers/${follow.producer.id}`"
                                ::image="follow.producer.user && follow.producer.user.pdp_path ? `/storage/${follow.producer.user.pdp_path}` : '{{ asset('images/producter.jpg') }}'"
                                ::producerId="follow.producer.id"
                            >
                                <p class="font-bold" x-text="follow.producer.city"></p>
                            </x-cards>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
