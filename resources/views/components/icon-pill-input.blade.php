@php
    $isFileInput = $attributes->get('type') === 'file';
    $placeholder = $attributes->get('placeholder', 'Choisir un fichier');
@endphp

<label class="relative w-full flex items-center px-6 py-2.5 sm:py-3 border-2 border-white focus-within:border-[#5db0e5] rounded-full bg-transparent hover:bg-white/20 cursor-pointer transition-all duration-200">
    @if($asterisk)
        <span class="absolute top-1.5 right-4 flex items-center justify-center text-red-700 [&>svg]:w-3 [&>svg]:h-3">
            {!! $getAsteriskSvg() !!}
        </span>
    @endif

    @if($icon)
        <span class="flex-shrink-0 flex items-center justify-center text-white mr-3 [&>svg]:w-7 [&>svg]:h-7">
            @if($svgContent = $getSvgIcon())
                {!! $svgContent !!}
            @else
                <img src="{{ asset($icon) }}" class="w-7 h-7" alt="icon">
            @endif
        </span>
    @endif

    @if($isFileInput)
        <span id="{{ $textId }}" class="flex-1 min-w-0 bg-transparent text-white/80 text-base font-medium tracking-wide truncate {{ $asterisk ? 'pr-4' : '' }}">
            {{ $placeholder }}
        </span>
        
        <input {{ $attributes->merge(['class' => 'hidden']) }} 
            onchange="
                const span = document.getElementById('{{ $textId }}');
                const hasFile = this.files.length > 0;
                span.innerText = hasFile ? this.files[0].name : '{{ $placeholder }}';
                span.classList.toggle('text-white', hasFile);
                span.classList.toggle('text-white/80', !hasFile);
            ">
    @else
        <input {{ $attributes->merge([
            'class' => 'flex-1 min-w-0 bg-transparent text-white placeholder-white/80 outline-none text-base font-medium tracking-wide focus:ring-0 border-none p-0 ' . ($asterisk ? 'pr-4' : '')
        ]) }}>
    @endif
</label>