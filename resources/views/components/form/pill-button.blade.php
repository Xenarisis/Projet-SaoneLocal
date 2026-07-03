<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-10 py-2.5 sm:py-3 text-white bg-transparent border-2 border-white rounded-full hover:bg-white/20 transition-all duration-200 text-sm font-medium tracking-wide focus:outline-none cursor-pointer']) }}>
    {{ $slot }}
</button>