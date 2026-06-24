@props(['icon' => null])

<div class="flex items-center px-5 py-2 border border-white rounded-full bg-transparent focus-within:ring-2 focus-within:ring-white focus-within:ring-offset-2 focus-within:ring-offset-[#00833F] transition-all duration-200">
    
    <!-- Emplacement pour l'icône (passée via l'attribut natif) -->
    @if($icon)
        <span class="flex-shrink-0 flex items-center justify-center text-white mr-3 [&>svg]:w-5 [&>svg]:h-5">
            @php
                $svgPath = public_path($icon);
            @endphp
            @if(file_exists($svgPath))
                {!! file_get_contents($svgPath) !!}
            @else
                <img src="{{ asset($icon) }}" class="w-5 h-5" alt="icon">
            @endif
        </span>
    @endif

    <input {{ $attributes->merge([
        'class' => 'w-full bg-transparent text-white placeholder-white/80 outline-none text-sm font-medium tracking-wide focus:ring-0 border-none p-0'
    ]) }}>
    
</div>