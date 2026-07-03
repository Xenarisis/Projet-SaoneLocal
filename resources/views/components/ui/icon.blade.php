@props([
    'name', 
    'class' => ''
])

@php
    $path = public_path("images/{$name}.svg");
    $svg = file_exists($path) ? file_get_contents($path) : '';
@endphp

<span {{ $attributes->merge(['class' => 'inline-block [&>svg]:w-full [&>svg]:h-full ' . $class]) }}>
    {!! $svg !!}
    {{ $slot }}
</span>
