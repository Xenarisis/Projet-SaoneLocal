<script>
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get('token');
    const isNew = urlParams.get('is_new');

    if (token) {
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