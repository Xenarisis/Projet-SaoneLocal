
<header class="z-50">
    <nav class="bg-red-blood text-white inset-x-0 w-4/5 mx-auto p-2 lg:p-3 rounded-full fixed top-0 mt-2 mb-2 flex justify-between items-center">
        <div class="flex-1 flex justify-start">
            <a href=" {{ route('home') }} ">
                <x-icon name="logo" class="h-10 w-10 lg:h-14 lg:w-14 m-1 ml-3 lg:m-2 lg:ml-6 hover:stroke-white/40 transition-colors" />
            </a>
        </div>
        <div class="flex-1 flex justify-center">
            <form action="{{ route('search') }}" method="GET" class="flex-1 flex justify-center">
                <input
                    type="search"
                    name="q"
                    class="relative m-0 block flex-auto rounded-l bg-white bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:outline-none max-w-[100px] lg:max-w-none max-h-[25px] lg:max-h-none"
                    placeholder="Search"
                    aria-label="Search"
                    id="searchInput"
                />
                <button
                    type="submit"
                    class="flex items-center rounded-r-full whitespace-nowrap px-3 py-[0.25rem] text-surface bg-white hover:bg-base-gray/30 [&>svg]:h-4 [&>svg]:w-5"
                    onclick="if (document.getElementById('searchInput').value === '' && document.activeElement === document.getElementById('searchInput')) {
                        event.preventDefault();
                        document.getElementById('SearchButton').click();
                    } else {
                        document.getElementById('searchInput').focus();
                    }"
                    id="SearchButton"
                >
                    <span class="inline-block h-4 w-4 lg:h-5 lg:w-5 text-black transition-colors [&>svg]:w-full [&>svg]:h-full">
                        {!! file_get_contents(public_path('images/search.svg')) !!}
                    </span>
                </button>
            </form>
        </div>
        <div class="flex-1 flex justify-end" x-data="cartBadge()" @cart-updated.window="fetchCount()">
            <a href="{{ route('cart') }}" class="relative inline-block mt-1 lg:mt-2 mx-1 lg:mx-2">
                <x-icon name="basket" class="h-8 w-8 lg:h-12 lg:w-12 hover:text-white/40 transition-colors" />
                <span x-cloak x-show="count > 0" x-transition x-text="count" class="absolute -bottom-1 -right-1 bg-red-blood text-white text-[10px] lg:text-xs font-bold rounded-full h-4 w-4 lg:h-5 lg:w-5 flex items-center justify-center shadow-md ring-2 ring-white"></span>
            </a>

            <div x-data="userMenu()">
                <x-dropdown width="w-48" align="right" >
                    <x-slot name="trigger">
                        <x-icon name="user" class="h-8 w-8 lg:h-12 lg:w-12 m-1 lg:m-2 text-white hover:text-gray-300 transition-colors cursor-pointer relative">
                            <span x-cloak x-show="newOrdersCount > 0" x-transition x-text="newOrdersCount" class="absolute -bottom-1 -right-1 bg-yellow-400 text-black text-[10px] lg:text-xs font-bold rounded-full h-4 w-4 lg:h-5 lg:w-5 flex items-center justify-center shadow-md ring-2 ring-white"></span>
                        </x-icon>
                    </x-slot>
                    <div>
                        <template x-if="!isLoggedIn">
                            <div>
                                <a href="{{ route('users.login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-xl">Connexion</a>
                                <a href="{{ route('users.register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-xl">S'inscrire</a>
                            </div>
                        </template>

                        <template x-if="isLoggedIn">
                            <div>
                                <a href="{{ route('users.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-xl">Voir son profil</a>
                                <a href="{{ route('users.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mes commandes</a>
                                <template x-if="isProducer">
                                    <a href="{{ route('producer.dashboard') }}" class="px-4 py-2 text-sm text-base-green font-semibold hover:bg-gray-100 flex justify-between items-center">
                                        Espace Producteur
                                        <span x-show="newOrdersCount > 0" x-text="newOrdersCount" class="bg-yellow-400 text-black text-xs font-bold px-2 py-0.5 rounded-full"></span>
                                    </a>
                                </template>
                                <a href="{{ route('logout.page') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 rounded-b-xl">Se déconnecter</a>
                            </div>
                        </template>
                    </div>
                </x-dropdown>
            </div>
        </div>
    </nav>
</header>