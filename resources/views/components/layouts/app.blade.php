{{-- resources/views/components/layouts/app.blade.php --}}


@props(['bgcolor' => '#DEDEDE'])

<!DOCTYPE html>
<html lang="fr">
    <x-header />

    <body style="background-color: {{ $bgcolor }}" class="text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col"> text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col pt-24 lg:pt-28

        <main>
            {{ $slot }}
        </main>

        <x-nav />
    </body>
    <x-footer />
</html>