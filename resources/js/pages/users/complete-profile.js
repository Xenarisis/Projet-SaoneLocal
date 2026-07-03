if (window.location.pathname === "/complete-profile") {
    (async () => {
        const token = sessionStorage.getItem('temp_jwt_token') || localStorage.getItem('jwt_token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        try {
            const res = await fetch('/api/users/me', {
                headers: { 
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            if (res.ok) {
                const json = await res.json();
                const user = json.data || json;
                document.getElementById('firstname').value = user.firstname || '';
                document.getElementById('lastname').value = user.lastname || '';
                document.getElementById('email').value = user.email || '';
                document.getElementById('username').value = user.username || '';

                document.getElementById('loading').style.display = 'none';
                document.getElementById('formContent').style.display = 'flex';
            } else {
                window.location.href = '/login';
            }
        } catch (err) {
            console.error(err);
            document.getElementById('loading').innerText = "Erreur de chargement.";
        }
    })();

    document.getElementById('completeProfileForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const token = sessionStorage.getItem('temp_jwt_token') || localStorage.getItem('jwt_token');
        if (!token) return;

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        const submitBtn = document.getElementById('submitBtn');
        const errorContainer = document.getElementById('errorMessages');

        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Validation...';
        errorContainer.classList.add('hidden');
        errorContainer.innerHTML = '';

        try {
            const response = await fetch('/api/users/complete-profile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                if (result.token) {
                    localStorage.setItem('jwt_token', result.token);
                    sessionStorage.removeItem('temp_jwt_token');
                }

                sessionStorage.setItem('flash_notification', JSON.stringify({
                    title: 'Bienvenue !',
                    description: 'Votre profil a bien été mis à jour.',
                    type: 'success'
                }));

                window.location.href = '/';
            } else {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Valider mon profil';

                let errorsHtml = '';
                if (result.errors) {
                    for (const [field, messages] of Object.entries(result.errors)) {
                        errorsHtml += `• ${messages[0]}<br>`;
                    }
                } else if (result.message) {
                    errorsHtml = `• ${result.message}`;
                } else {
                    errorsHtml = '• Une erreur est survenue.';
                }

                errorContainer.innerHTML = errorsHtml;
                errorContainer.classList.remove('hidden');
            }
        } catch (error) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Valider mon profil';
            errorContainer.innerHTML = '• Erreur de connexion au serveur.';
            errorContainer.classList.remove('hidden');
        }
    });
}
