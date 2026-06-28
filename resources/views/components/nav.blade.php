{{-- resources/views/components/nav.blade.php --}}

<div class="fixed inset-x-0 bottom-0 w-4/5 mx-auto mb-2">
    <x-tab />

    <nav class="bg-[#820606] text-[#DEDEDE] w-full rounded-full p-2 lg:p-3 flex justify-around mt-2" >
        <a href=" {{ route('home') }} " class="text-xs lg:text-sm px-1 lg:px-2 hover:text-white/40" >
            accueil
        </a>
        <a href="" class="text-xs lg:text-sm px-1 lg:px-2 hover:text-white/40" >
            calendrier
        </a>
        <a href="" class="text-xs lg:text-sm px-1 lg:px-2 hover:text-white/40" >
            à propos
        </a>
        <a href="" class="text-xs lg:text-sm px-1 lg:px-2 hover:text-white/40" >
            paramètres
        </a>
    </nav>
</div>