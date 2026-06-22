{{-- resources/views/components/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<x-header />
<body>

    <main>
        {{ $slot }}
    </main>
<x-nav />
</body>
<x-footer />
</html>