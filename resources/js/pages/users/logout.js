if (window.location.pathname === "/logout") {
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
}
