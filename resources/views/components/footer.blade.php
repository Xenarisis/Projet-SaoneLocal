{{-- resources/views/components/footer.blade.php --}}

<footer class="mx-auto mt-32 w-full max-w-container px-4 sm:px-6 lg:px-8 pb-24">
    <div class="items-centers grid grid-cols-1 justify-between gap-4 border-t py-6 md:grid-cols-2 ">
        <p class="text-sm/6 text-gray-600 max-md:text-center dark:text-base-gray">
            &copy SaoneLocal - 2026 | <a href="{{ route('about') }}">plus sur nous</a> | <a href="{{ route('contact') }}">Devenir producteur | Nous contacter</a> | <a href="{{ route('mentionlegale') }}">Mention légale</a> | <a href="{{ route('CGV') }}">Contrat générale de vente</a> | <a href="{{ route('CGU') }}">Contrat générale d'utilisation</a> 
        </p>
        
        <div class="flex items-center justify-center space-x-4 text-sm/6 text-gray-500 md:justify-end dark:text-base-gray">
            <img src="{{ asset('images/twitter.svg') }}" alt="twitter" class="h-8 w-8 lg:h-10 lg:w-10 m-1 lg:m-2 hover:text-white/40 transition-colors [&>svg]:w-full [&>svg]:h-full">
            <img src="{{ asset('images/instagram.svg') }}" alt="insta" class="h-8 w-8 lg:h-10 lg:w-10 m-1 lg:m-2 hover:text-white/40 transition-colors [&>svg]:w-full [&>svg]:h-full">
            <img src="{{ asset('images/tiktok.svg') }}" alt="tiktok" class="h-8 w-8 lg:h-10 lg:w-10 m-1 lg:m-2 hover:text-white/40 transition-colors [&>svg]:w-full [&>svg]:h-full">
        </div>
    </div>
</footer>