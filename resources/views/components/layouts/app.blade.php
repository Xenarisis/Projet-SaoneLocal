@props(['bgcolor' => '#DEDEDE', 'title' => null])

<!DOCTYPE html>
<html lang="fr" {{ $attributes }}>
    <x-header/>
    <body style="background-color: {{ $bgcolor }}" class="text-dark flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col pt-24 lg:pt-28">
        <x-notification/>
        <x-alert/>
        <main>
            {{ $slot }}
        </main>
        <x-nav/>
    </body>
    <x-footer/>
</html>