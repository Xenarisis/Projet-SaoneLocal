<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-10 py-2 text-white bg-transparent border border-white rounded-full hover:bg-white/20 transition-colors duration-200 text-sm font-medium tracking-wide focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#00833F]']) }}>
    {{ $slot }}
</button>