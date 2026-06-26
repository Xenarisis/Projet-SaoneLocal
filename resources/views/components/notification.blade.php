<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-init="setTimeout(() => show = false, 5000)"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-4"
    {{ $attributes->merge(['class' => 'fixed top-4 right-4 z-50 flex items-start w-full max-w-sm p-4 gap-3 bg-white border border-slate-200 rounded-lg shadow-lg dark:bg-slate-800 dark:border-slate-700']) }}
>
    <div class="flex-shrink-0">
        <div 
            class="w-8 h-8 {{ $color() }}" 
            style="mask-image: url('{{ asset($icon()) }}'); -webkit-mask-image: url('{{ asset($icon()) }}'); mask-size: contain; -webkit-mask-size: contain; mask-repeat: no-repeat; -webkit-mask-repeat: no-repeat; mask-position: center; -webkit-mask-position: center;"
            aria-label="{{ ucfirst($type) }} icon"
            role="img"
        ></div>
    </div>

    <div class="flex flex-col flex-1">
        <span class="text-base font-semibold text-slate-800 dark:text-white">
            {{ $title }}
        </span>
        <span class="text-sm text-slate-500 mt-0.5 dark:text-slate-400">
            {{ $description }}
        </span>
    </div>

    <div class="flex-shrink-0 ml-2">
        <button 
            @click="show = false" 
            type="button" 
            class="text-slate-400 transition-colors hover:text-slate-600 dark:hover:text-slate-200 focus:outline-none" 
            aria-label="Fermer la notification"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>