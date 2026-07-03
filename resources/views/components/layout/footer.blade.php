<footer class="mx-auto mt-32 w-full max-w-container px-4 sm:px-6 lg:px-8 pb-24">
    <div class="flex flex-col items-center justify-between gap-6 border-t py-6 xl:flex-row">
        <p class="text-sm/6 text-gray-600 max-xl:text-center dark:text-base-gray capitalize flex flex-wrap justify-center xl:justify-start gap-x-2 gap-y-1">
            <span>&copy; SaoneLocal - 2026</span>
            <span class="hidden xl:inline">|</span>
            <a href="{{ route('about') }}" class="hover:text-gray-900 dark:hover:text-white hover:underline transition-all">plus sur nous</a>
            <span class="hidden xl:inline">|</span>
            <a href="{{ route('contact') }}" class="hover:text-gray-900 dark:hover:text-white hover:underline transition-all">Nous contacter</a>
            <span class="hidden xl:inline">|</span>
            <a href="{{ route('mentionlegale') }}" class="hover:text-gray-900 dark:hover:text-white hover:underline transition-all">Mention légale</a>
            <span class="hidden xl:inline">|</span>
            <a href="{{ route('CGV') }}" class="hover:text-gray-900 dark:hover:text-white hover:underline transition-all">Contrat générale de vente</a>
            <span class="hidden xl:inline">|</span>
            <a href="{{ route('CGU') }}" class="hover:text-gray-900 dark:hover:text-white hover:underline transition-all">Contrat générale d'utilisation</a> 
        </p>
        
        <div class="flex items-center justify-center space-x-6 text-sm/6 text-gray-500 xl:justify-end dark:text-base-gray">
            <a href="#" class="hover:scale-110 hover:-translate-y-1 hover:opacity-80 transition-all duration-300">
                <img src="{{ asset('images/twitter.svg') }}" alt="twitter" class="h-6 w-6 lg:h-7 lg:w-7">
            </a>
            <a href="#" class="hover:scale-110 hover:-translate-y-1 hover:opacity-80 transition-all duration-300">
                <img src="{{ asset('images/instagram.svg') }}" alt="insta" class="h-6 w-6 lg:h-7 lg:w-7">
            </a>
            <a href="#" class="hover:scale-110 hover:-translate-y-1 hover:opacity-80 transition-all duration-300">
                <img src="{{ asset('images/tiktok.svg') }}" alt="tiktok" class="h-6 w-6 lg:h-7 lg:w-7">
            </a>
        </div>
    </div>
</footer>