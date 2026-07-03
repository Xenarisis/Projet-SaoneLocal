<x-layouts.app title="Connexion Google - SaôneLocal">
    <div class="flex items-center justify-center min-h-[50vh]">
        <div class="text-center">
            <svg class="animate-spin h-8 w-8 text-emerald-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600 font-medium">Redirection en cours...</p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            const error = urlParams.get('error');
            const isNew = urlParams.get('is_new');

            if (error) {
                let msg = 'Une erreur est survenue.';
                if (error === 'already_linked') msg = 'Ce compte Google est déjà lié à un autre compte.';
                sessionStorage.setItem('flash_notification', JSON.stringify({
                    title: 'Erreur',
                    description: msg,
                    type: 'error'
                }));
                window.location.href = '/login';
                return;
            }

            if (token) {
                if (isNew === '1') {
                    sessionStorage.setItem('temp_jwt_token', token);
                    window.location.href = '/complete-profile';
                } else {
                    localStorage.setItem('jwt_token', token);
                    window.location.href = '/';
                }
            } else {
                window.location.href = '/login';
            }
        });
    </script>
</x-layouts.app>