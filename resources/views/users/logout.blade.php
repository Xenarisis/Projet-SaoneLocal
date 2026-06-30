<x-layouts.app title="Déconnexion">
    <div class="min-h-screen flex flex-col justify-center items-center p-4 font-body">
        <div class="bg-base-green w-full max-w-[400px] rounded-[32px] shadow-2xl p-8 flex flex-col items-center">
            <h1 class="text-white text-center font-bold text-2xl mb-4">
                Déconnexion en cours...
            </h1>

            <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('jwt_token');
            if (token) {
                fetch('/api/users/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                }).catch(e => console.error("Erreur lors de la déconnexion API", e));
            }

            localStorage.removeItem('jwt_token');

            sessionStorage.setItem('flash_notification', JSON.stringify({
                title: 'À bientôt !',
                description: 'Vous avez été déconnecté avec succès.',
                type: 'info'
            }));

            window.location.href = '/';
        });
    </script>
</x-layouts.app>
