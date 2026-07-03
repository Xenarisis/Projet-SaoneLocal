const guestOnlyPages = ['/login', '/register'];

const token = localStorage.getItem('jwt_token');
let isTokenValid = false;
if (token) {
    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        if (payload.exp && payload.exp * 1000 > Date.now()) {
            isTokenValid = true;
        } else {
            localStorage.removeItem('jwt_token');
        }
    } catch (e) {
        localStorage.removeItem('jwt_token');
    }
}

if (isTokenValid && guestOnlyPages.includes(window.location.pathname)) {
    window.location.href = '/';
    sessionStorage.setItem('flash_notification', JSON.stringify({
        title: 'Information',
        description: 'Vous êtes déjà connecté.',
        type: 'info'
    }));
}
const registerForm = document.getElementById('registerForm');

if(registerForm) {
    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('submitBtn');
        let isSuccess = false; 

        submitBtn.textContent = 'Création en cours...';
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-70', 'cursor-not-allowed');

        const formData = new FormData(form);

        try {
            const response = await fetch('/api/users/register', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if(response.ok) {
                isSuccess = true; 

                if(data.access_token) {
                    localStorage.setItem('jwt_token', data.access_token);
                
                    sessionStorage.setItem('flash_notification', JSON.stringify({
                        title: 'Bienvenue !',
                        description: 'Votre compte a été créé avec succès.',
                        type: 'success'
                    }));
                    
                    submitBtn.textContent = 'Redirection...';
                    

                    window.location.href = '/';
                } else {
                    sessionStorage.setItem('flash_notification', JSON.stringify({
                        title: 'Erreur !',
                        description: 'Impossible de récupérer le token.',
                        type: 'error'
                    }));
                    
                }

            } else {
                let errorText = '';
                if(data.errors) {
                    errorText = Object.values(data.errors).map(err => `• ${err[0]}`).join('<br>');
                } else {
                    errorText = data.message || 'Une erreur est survenue lors de l\'inscription.';
                }
                
                window.showNotification('Erreur d\'inscription', errorText, 'error');
            }
        } catch (error) {
            console.error(error);
            window.showNotification('Erreur réseau', 'Impossible de contacter l\'API.', 'error');
        } finally {
            if(!isSuccess) {
                submitBtn.textContent = 'Créer mon compte';
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-70', 'cursor-not-allowed');
            }
        }
    });
}