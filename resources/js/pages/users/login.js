if (document.getElementById("loginForm")) {
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        const submitBtn = document.getElementById('submitBtn');
        const errorContainer = document.getElementById('errorMessages');

        submitBtn.disabled = true;
        submitBtn.querySelector('div').innerHTML = 'Connexion...';
        errorContainer.classList.add('hidden');
        errorContainer.innerHTML = '';

        try {
            const response = await fetch('/api/users/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                localStorage.setItem('jwt_token', result.access_token);

                sessionStorage.setItem('flash_notification', JSON.stringify({
                    title: 'Bon retour !',
                    description: result.message || 'Connexion réussie.',
                    type: 'success'
                }));

                window.location.href = '/';
            } else {
                submitBtn.disabled = false;
                submitBtn.querySelector('div').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg> Se connecter`;

                let errorsHtml = '';
                if (result.errors) {
                    for (const [field, messages] of Object.entries(result.errors)) {
                        errorsHtml += `• ${messages[0]}<br>`;
                    }
                } else if (result.message) {
                    errorsHtml = `• ${result.message}`;
                } else {
                    errorsHtml = '• Une erreur est survenue lors de la connexion.';
                }

                errorContainer.innerHTML = errorsHtml;
                errorContainer.classList.remove('hidden');
            }
        } catch (error) {
            submitBtn.disabled = false;
            submitBtn.querySelector('div').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg> Se connecter`;
            errorContainer.innerHTML = '• Erreur de connexion au serveur.';
            errorContainer.classList.remove('hidden');
        }
    });
}
