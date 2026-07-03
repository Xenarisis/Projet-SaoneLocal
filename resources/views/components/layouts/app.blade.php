@props(['title' => null])

<!DOCTYPE html>
<html lang="fr" {{ $attributes }} x-data="{ dark: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': dark }">
    <x-header/>
    <body class=" flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col pt-24 lg:pt-28 bg-base-gray dark:bg-cachou text-cachou dark:text-base-gray">
        <x-notification/>
        <x-alert/>
        <main>
            {{ $slot }}
        </main>
        <x-nav/>
    </body>
    <x-footer/>
</html>