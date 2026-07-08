window.profileData = function() {
    return {
        user: null,
        loading: true,
        saving: false,
        fetchError: null,
        error: null,
        successMessage: null,
        editForm: {
            firstname: '',
            lastname: '',
            username: '',
            email: '',
            password: '',
            password_confirmation: '',
            producer_name: '',
            presentation: '',
            street_line_1: '',
            street_line_2: '',
            city: '',
            postal_code: ''
        },
        saveTimeout: null,
        lastSaved: null,
        linkGoogle() {
            const token = localStorage.getItem('jwt_token');
            window.location.href = `/auth/google/redirect?token=${token}`;
        },
        debouncedSave() {
            if (this.saveTimeout) clearTimeout(this.saveTimeout);
            this.saveTimeout = setTimeout(() => {
                if (!this.editForm.firstname || !this.editForm.lastname || !this.editForm.username || !this.editForm.email) {
                    return;
                }
                
                if (this.user?.role === 'producer') {
                    if (!this.editForm.producer_name || !this.editForm.street_line_1 || !this.editForm.postal_code || !this.editForm.city) {
                        return;
                    }
                }
                
                this.saveProfile();
            }, 1000);
        },
        async init() {
            const token = localStorage.getItem('jwt_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            try {
                const res = await fetch('/api/users/me', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    const json = await res.json();
                    this.user = json.data || json;
                    this.editForm = {
                        firstname: this.user.firstname || '',
                        lastname: this.user.lastname || '',
                        username: this.user.username || '',
                        email: this.user.email || '',
                        password: '',
                        password_confirmation: '',
                        producer_name: this.user.producer?.name || '',
                        presentation: this.user.producer?.presentation || '',
                        street_line_1: this.user.producer?.street_line_1 || '',
                        street_line_2: this.user.producer?.street_line_2 || '',
                        city: this.user.producer?.city || '',
                        postal_code: this.user.producer?.postal_code || ''
                    };
                } else {
                    localStorage.removeItem('jwt_token');
                    window.location.href = '/login';
                }
            } catch (e) {
                console.error('Erreur', e);
                this.fetchError = 'Impossible de charger vos données. Veuillez vérifier votre connexion.';
            } finally {
                this.loading = false;
            }
        },
        async deleteAccount() {
            window.dispatchEvent(new CustomEvent('open-alert', {
                detail: {
                    title: 'Suppression du compte',
                    message: "Êtes-vous sûr de vouloir supprimer définitivement votre compte ? Cette action est irréversible.",
                    type: 'confirm',
                    onConfirm: async () => {
                        try {
                            const token = localStorage.getItem('jwt_token');
                const res = await fetch(`/api/users/${this.user.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    localStorage.removeItem('jwt_token');
                    sessionStorage.setItem('flash_notification', JSON.stringify({
                        title: 'Compte supprimé',
                        description: 'Votre compte a été définitivement supprimé.',
                        type: 'info'
                    }));
                    window.location.href = '/login';
                } else {
                    const data = await res.json();
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            title: 'Erreur',
                            description: data.message || 'Impossible de supprimer le compte.',
                            type: 'error'
                        }
                    }));
                }
            } catch (e) {
                console.error(e);
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: {
                        title: 'Erreur réseau',
                        description: 'Impossible de joindre le serveur.',
                        type: 'error'
                    }
                }));
                    }
                }
            }
            }));
        },
        async becomeProducer() {
            window.dispatchEvent(new CustomEvent('open-alert', {
                detail: {
                    title: 'Devenir producteur',
                    message: "Souhaitez-vous vraiment activer votre espace producteur ? Vous pourrez ensuite renseigner les informations de votre organisation.",
                    type: 'confirm',
                    onConfirm: async () => {
                        try {
                            const token = localStorage.getItem('jwt_token');
                            const res = await fetch(`/api/users/${this.user.id}/become-producer`, {
                                method: 'POST',
                                headers: {
                                    'Authorization': 'Bearer ' + token,
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await res.json();

                            if (res.ok) {
                                this.user = data.user;
                                this.editForm.producer_name = this.user.producer?.name || '';
                                this.editForm.presentation = this.user.producer?.presentation || '';
                                this.editForm.street_line_1 = this.user.producer?.street_line_1 || '';
                                this.editForm.street_line_2 = this.user.producer?.street_line_2 || '';
                                this.editForm.city = this.user.producer?.city || '';
                                this.editForm.postal_code = this.user.producer?.postal_code || '';
                                
                                if (data.token) {
                                    localStorage.setItem('jwt_token', data.token);
                                }
                                
                                window.dispatchEvent(new CustomEvent('notify', {
                                    detail: {
                                        title: 'Félicitations !',
                                        description: data.message,
                                        type: 'success'
                                    }
                                }));
                            } else {
                                window.dispatchEvent(new CustomEvent('notify', {
                                    detail: {
                                        title: 'Erreur',
                                        description: data.message || 'Action impossible.',
                                        type: 'error'
                                    }
                                }));
                            }
                        } catch (e) {
                            console.error(e);
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Erreur réseau',
                                    description: 'Impossible de joindre le serveur.',
                                    type: 'error'
                                }
                            }));
                        }
                    }
                }
            }));
        },
        async stopProducer() {
            window.dispatchEvent(new CustomEvent('open-alert', {
                detail: {
                    title: 'Ne plus être producteur',
                    message: "Êtes-vous sûr de vouloir désactiver votre espace producteur ? Vos produits seront masqués et toutes vos commandes en cours seront annulées.",
                    type: 'confirm',
                    onConfirm: async () => {
                        try {
                            const token = localStorage.getItem('jwt_token');
                            const res = await fetch(`/api/users/${this.user.id}/stop-producer`, {
                                method: 'POST',
                                headers: {
                                    'Authorization': 'Bearer ' + token,
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await res.json();

                            if (res.ok) {
                                this.user = data.user;
                                
                                if (data.token) {
                                    localStorage.setItem('jwt_token', data.token);
                                }
                                
                                window.dispatchEvent(new CustomEvent('notify', {
                                    detail: {
                                        title: 'Désactivation réussie',
                                        description: data.message,
                                        type: 'success'
                                    }
                                }));
                            } else {
                                window.dispatchEvent(new CustomEvent('notify', {
                                    detail: {
                                        title: 'Erreur',
                                        description: data.message || 'Action impossible.',
                                        type: 'error'
                                    }
                                }));
                            }
                        } catch (e) {
                            console.error(e);
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Erreur réseau',
                                    description: 'Impossible de joindre le serveur.',
                                    type: 'error'
                                }
                            }));
                        }
                    }
                }
            }));
        },
        async saveAvatar() {
            this.saving = true;

            try {
                const formData = new FormData();
                formData.append('_method', 'PATCH');
                
                const pdpInput = document.getElementById('pdp_path');
                if (pdpInput && pdpInput.files.length > 0) {
                    formData.append('pdp', pdpInput.files[0]);
                }
                const deleteInput = document.querySelector('input[name="delete_pdp_path"]');
                if (deleteInput && deleteInput.value === '1') {
                    formData.append('delete_pdp', 1);
                }

                const token = localStorage.getItem('jwt_token');
                const res = await fetch(`/api/users/${this.user.id}`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await res.json();

                if (res.ok) {
                    this.user = data.data;
                    this.lastSaved = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: { title: 'Photo mise à jour', description: 'Votre photo a été enregistrée.', type: 'success' }
                    }));
                } else {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: { title: 'Erreur', description: data.message || 'Erreur lors de l\'enregistrement.', type: 'error' }
                    }));
                }
            } catch (e) {
                console.error(e);
            } finally {
                this.saving = false;
            }
        },
        async saveProfile() {
            this.saving = true;

            try {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('firstname', this.editForm.firstname);
                formData.append('lastname', this.editForm.lastname);
                formData.append('username', this.editForm.username);
                formData.append('email', this.editForm.email);
                if (this.editForm.password) {
                    formData.append('password', this.editForm.password);
                    formData.append('password_confirmation', this.editForm.password_confirmation);
                }
                if (this.user.role === 'producer') {
                    formData.append('producer_name', this.editForm.producer_name);
                    formData.append('presentation', this.editForm.presentation);
                    formData.append('street_line_1', this.editForm.street_line_1);
                    formData.append('street_line_2', this.editForm.street_line_2);
                    formData.append('city', this.editForm.city);
                    formData.append('postal_code', this.editForm.postal_code);
                }
                const pdpInput = document.getElementById('pdp_path');
                if (pdpInput && pdpInput.files.length > 0) {
                    formData.append('pdp', pdpInput.files[0]);
                }
                const deleteInput = document.querySelector('input[name="delete_pdp_path"]');
                if (deleteInput && deleteInput.value === '1') {
                    formData.append('delete_pdp', 1);
                }

                const token = localStorage.getItem('jwt_token');
                const res = await fetch(`/api/users/${this.user.id}`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await res.json();

                if (res.ok) {
                    this.user = data.data || { ...this.user, ...this.editForm };
                    
                    this.lastSaved = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            title: 'Profil mis à jour',
                            description: data.message || 'Vos informations ont été mises à jour avec succès !',
                            type: 'success'
                        }
                    }));
                } else {
                    let errorMsg = data.message || 'Une erreur est survenue lors de la mise à jour.';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors).map(msg => msg.join(', ')).join('<br>');
                    }
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            title: 'Erreur',
                            description: errorMsg,
                            type: 'error'
                        }
                    }));
                }
            } catch (e) {
                console.error(e);
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: {
                        title: 'Erreur réseau',
                        description: 'Impossible de joindre le serveur.',
                        type: 'error'
                    }
                }));
            } finally {
                this.saving = false;
            }
        }
    }
}