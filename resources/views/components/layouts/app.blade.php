@props([
    'bgcolor' => '#DEDEDE', 
    'title' => 'SaôneLocal', 
    'description' => 'Découvrez les meilleurs produits locaux et les producteurs de votre région sur SaôneLocal.', 
    'robots' => 'index, follow'
])

<!DOCTYPE html>
<html lang="fr" {{ $attributes }} x-data="{ dark: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': dark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description }}">
        <meta name="robots" content="{{ $robots }}">

        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="SaôneLocal">

        <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Lemon&family=Varela+Round&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class=" flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col pt-24 lg:pt-28 bg-base-gray dark:bg-cachou text-cachou dark:text-base-gray">
        <x-header />
        <x-notification/>
        <x-alert/>
        <main class="w-full max-w-screen-xl mx-auto flex flex-col">
            {{ $slot }}
        </main>
        <x-nav/>
        <x-footer/>
    </body>
</html>