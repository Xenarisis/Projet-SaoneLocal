@props(['icon' => null])

<div class="w-full flex items-center px-6 py-2.5 sm:py-3 border-2 border-white rounded-full bg-transparent hover:bg-white/20 cursor-text transition-all duration-200"> <!-- focus-within:bg-white/20 -->
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