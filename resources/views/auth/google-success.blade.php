<script>
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    const isNew = urlParams.get('is_new');
    const linked = urlParams.get('linked');
    const error = urlParams.get('error');

    if (error === 'already_linked') {
        sessionStorage.setItem('flash_notification', JSON.stringify({
            title: 'Erreur',
            description: 'Ce compte Google est déjà associé à un autre utilisateur.',
            type: 'error'
        }));
        window.location.href = '/profile';
    } else if (linked === '1') {
        sessionStorage.setItem('flash_notification', JSON.stringify({
            title: 'Compte associé',
            description: 'Votre compte Google a été associé avec succès.',
            type: 'success'
        }));
        window.location.href = '/profile';
    } else if (token) {
        if (isNew === '1') {
            sessionStorage.setItem('temp_jwt_token', token);
            window.location.href = '/complete-profile';
        } else {
            localStorage.setItem('jwt_token', token);
            sessionStorage.setItem('flash_notification', JSON.stringify({
                title: 'Bon retour !',
                description: 'Connexion avec Google réussie.',
                type: 'success'
            }));
            window.location.href = '/';
        }
    } else {
        window.location.href = '/login';
    }
</script>