<x-layouts.app title="Compte banni - SaôneLocal">
    <div class="min-h-screen bg-gray-100 flex justify-center items-center p-4">
        <div class="bg-white p-10 rounded-lg shadow-md text-center max-w-md w-full">
            <h1 class="text-red-600 text-2xl font-bold mb-4">Compte suspendu</h1>
            <p class="text-gray-600 leading-relaxed mb-6">Votre compte a été banni par un administrateur. Vous ne pouvez plus accéder à SaôneLocal.</p>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-gray-800 text-white border-none py-2 px-5 rounded hover:bg-gray-900 transition-colors cursor-pointer text-base">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
