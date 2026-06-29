<x-layouts.app title="Compléter le profil">
    <div class="min-h-screen bg-[#dcdcdc] flex flex-col justify-center items-center p-4 font-sans">
        <form id="completeProfileForm" 
            class="bg-[#057941] w-full max-w-[600px] rounded-[32px] shadow-[0_0_15px_rgba(93,176,229,0.4)] p-8 sm:p-10 flex flex-col items-center relative">
            @csrf

            <div class="mb-10 flex flex-col gap-2 w-full items-center">
                <h1 class="text-white text-center font-bold text-4xl tracking-wide">
                    Dernière étape
                </h1>
                
                <div class="h-px w-full max-w-sm bg-gradient-to-r from-transparent via-white to-transparent my-4"></div>

                <p class="text-sm text-white text-center">Veuillez vérifier vos informations et choisir un nom d'utilisateur pour terminer votre inscription.</p>
            </div>

            <div id="errorMessages" class="hidden w-full bg-red-500/20 border border-red-500 text-white rounded-lg p-3 mb-6 text-sm leading-relaxed"></div>

            <div class="w-full flex flex-col gap-8" id="formContent" style="display: none;">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 w-full">
                    <x-icon-pill-input
                        type="text"
                        name="firstname"
                        id="firstname"
                        required
                        placeholder="Prénom"
                        icon="images/user.svg"
                        :asterisk="true"
                    />
                    <x-icon-pill-input
                        type="text"
                        name="lastname"
                        id="lastname"
                        required
                        placeholder="Nom"
                        icon="images/user.svg"
                        :asterisk="true"
                    />
                </div>

                <x-icon-pill-input
                    type="email"
                    name="email"
                    id="email"
                    required
                    placeholder="Email"
                    icon="images/mail.svg"
                    :asterisk="true"
                />

                <x-icon-pill-input
                    type="text"
                    name="username"
                    id="username"
                    required
                    placeholder="Nom d'utilisateur"
                    icon="images/user.svg"
                    :asterisk="true"
                />

                <div class="mt-8 flex justify-center w-full">
                    <x-pill-button type="submit" id="submitBtn">
                        Valider mon profil
                    </x-pill-button>
                </div>
            </div>
            
            <div id="loading" class="text-white text-center w-full py-10">Chargement de vos informations...</div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = sessionStorage.getItem('temp_jwt_token') || localStorage.getItem('jwt_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            try {
                const res = await fetch('/api/users/me', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                if (res.ok) {
                    const user = await res.json();
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
        });

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
    </script>
</x-layouts.app>
