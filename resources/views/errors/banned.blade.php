<x-layouts.app title="Compte banni - SaôneLocal">
    <div class="flex flex-col justify-center items-center py-12 sm:py-20 px-4 sm:px-6 text-center">
        <div class="w-full max-w-sm">
            <h1 class="text-red-600 text-2xl sm:text-3xl font-bold mb-4">Compte suspendu</h1>
            <p class="text-gray-700 text-sm sm:text-base leading-relaxed mb-8">
                Votre compte a été banni par un administrateur. Vous ne pouvez plus accéder aux fonctionnalités de SaôneLocal.
            </p>
            
            <div class="flex flex-col gap-3 w-full">
                <button id="logoutBtn" class="bg-gray-800 text-white border-none py-3 px-4 rounded-full hover:bg-gray-900 transition-colors cursor-pointer text-sm font-bold shadow w-full active:scale-95">
                    Se déconnecter
                </button>
                <button id="deleteAccountBtn" class="bg-red-600 text-white border-none py-3 px-4 rounded-full hover:bg-red-700 transition-colors cursor-pointer text-sm font-bold shadow w-full active:scale-95">
                    Supprimer mon compte
                </button>
            </div>
            
            <p id="errorMessage" class="text-red-500 mt-4 hidden text-sm font-medium"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = localStorage.getItem('jwt_token');
            if (!token) {
                window.location.href = '/';
                return;
            }

            try {
                const response = await fetch('/api/users/me', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    window.location.href = '/';
                }
            } catch (err) {}
        });

        document.getElementById('logoutBtn').addEventListener('click', async function() {
            const token = localStorage.getItem('jwt_token');
            if (token) {
                try {
                    await fetch('/api/users/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });
                } catch (err) {
                    // Ignorer l'erreur réseau pour forcer la déco locale
                }
            }
            localStorage.removeItem('jwt_token');
            window.location.href = '/';
        });

        document.getElementById('deleteAccountBtn').addEventListener('click', async function() {
            if (!confirm('Êtes-vous sûr de vouloir supprimer définitivement votre compte ? Cette action est irréversible.')) {
                return;
            }

            const token = localStorage.getItem('jwt_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            try {
                // Decode JWT to get user ID
                const base64Url = token.split('.')[1];
                const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                const jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''));
                const payload = JSON.parse(jsonPayload);
                const userId = payload.sub;

                const response = await fetch(`/api/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    localStorage.removeItem('jwt_token');
                    alert('Votre compte a été supprimé avec succès.');
                    window.location.href = '/';
                } else {
                    document.getElementById('errorMessage').textContent = 'Erreur lors de la suppression du compte.';
                    document.getElementById('errorMessage').classList.remove('hidden');
                }
            } catch (err) {
                document.getElementById('errorMessage').textContent = 'Erreur serveur.';
                document.getElementById('errorMessage').classList.remove('hidden');
            }
        });
    </script>
</x-layouts.app>
