@php
    $linkClasses = "text-[11px] sm:text-sm font-medium tracking-wide whitespace-nowrap px-2 py-1 rounded hover:bg-white/20 transition-colors";
@endphp

<div class="fixed inset-x-0 bottom-3 w-[96%] sm:w-4/5 mx-auto z-50 flex flex-col gap-2">
    <x-tab />

    <nav class="bg-red-blood text-white w-full rounded-full py-3 px-1 sm:px-4 flex justify-around items-center shadow-xl backdrop-blur-sm" >
        <a href="{{ route('home') }}" class="{{ $linkClasses }}" >
            Accueil
        </a>
        <a href="{{ route('calendar') }}" class="{{ $linkClasses }}" >
            Calendrier
        </a>
        <a href="{{ route('about') }}" class="{{ $linkClasses }}" >
            À propos
        </a>
        <a href="" class="{{ $linkClasses }}" >
            Paramètres
        </a>
    </nav>
</div>