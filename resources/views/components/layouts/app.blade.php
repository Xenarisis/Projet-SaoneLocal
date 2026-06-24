{{-- resources/views/components/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<x-header />
<body class="bg-[#DEDEDE] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    <main>
        {{ $slot }}
    </main>

<x-nav />
</body>
<x-footer />
</html>