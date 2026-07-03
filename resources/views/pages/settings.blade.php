{{-- resources/views/pages/settings.blade.php --}}

<x-layouts.app title="Paramètres">
    <div class="w-screen px-4 py-8 flex justify-center m-4">
        
        <div class="flex flex-col items-center w-full max-w-4xl rounded-2xl p-4 bg-white/30 shadow-sm">

            <h1 class="font-bold text-2xl text-center rounded-2xl bg-base-green text-base-gray p-3 mb-6 w-4/5">
                Paramètres
            </h1>

            <div class="flex flex-col gap-6 w-3/5">
                <section class="bg-base-green/30 rounded-2xl p-4 shadow-sm m-1 lg:m-2 mb-2 hover:bg-base-green/50">
                    <a href="" class="flex justify-center items-center">
                        <h2 class="font-bold text-lg">Compte Utilisateur</h2>
                        <span class="inline-block h-8 w-8 lg:h-10 lg:w-10 text-dark transition-colors [&>svg]:w-full [&>svg]:h-full cursor-pointer">
                            {!! file_get_contents(public_path('images/user.svg')) !!}
                        </span>
                    </a>
                </section>

                <section class="bg-base-green/30 rounded-2xl p-4 shadow-sm m-1 lg:m-2 mb-15 hover:bg-base-green/50 text-center">
                    <button @click="dark = !dark; localStorage.setItem('theme', dark ? 'dark' : 'light')">
                        <h2 class="font-bold text-lg">Mode Sombre/clair | <span x-show="!dark">🌙</span> <span x-show="dark">☀️</span></h2>
                    </button>
                </section>

                <section class="bg-base-green/30 rounded-2xl p-4 shadow-sm m-1 lg:m-2 mb-2 hover:bg-base-green/50">
                    <a href="{{ route('contact') }}" class="flex justify-center items-center">
                        <h2 class="font-bold text-lg">Contacter le support</h2>
                    </a>
                </section>

                <section class="bg-base-green/30 rounded-2xl p-4 shadow-sm m-1 lg:m-2 mb-2 hover:bg-base-green/50">
                    <a href="{{ route('about') }}" class="flex justify-center items-center">
                        <h2 class="font-bold text-lg">Valeur de l'association</h2>
                    </a>
                </section>

                <section class="bg-base-green/30 rounded-2xl p-4 shadow-sm m-1 lg:m-2 mb-2 hover:bg-base-green/50">
                    <a href="{{ route('CGU') }}" class="flex justify-center items-center">
                        <h2 class="font-bold text-lg">Contrat générale d'utilisation</h2>
                    </a>
                </section>
                
                <section class="bg-base-green/30 rounded-2xl p-4 shadow-sm m-1 lg:m-2 mb-2 hover:bg-base-green/50">
                    <a href="{{ route('CGV') }}" class="flex justify-center items-center">
                        <h2 class="font-bold text-lg">Contrat générale de vente</h2>
                    </a>
                </section>

            </div>
        </div>
    </div>   
</x-layouts.app>