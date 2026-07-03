window.productForm = function() {
            return {
                loading: false,
                saving: false,
                productId: null,
                form: {
                    name: '',
                    description: '',
                    price: '',
                    unit: '',
                    quantity: '',
                    category: '',
                    subcategory: ''
                },

                async init() {
                    const token = localStorage.getItem('jwt_token');
                    if (!token) {
                        window.location.href = '/login';
                        return;
                    }

                    const match = window.location.pathname.match(/\/products\/(\d+)\/edit/);
                    if (match) {
                        this.productId = match[1];
                        this.loading = true;
                        try {
                            const res = await fetch(`/api/products/${this.productId}`);
                            if (res.ok) {
                                const data = await res.json();
                                this.form = {
                                    name: data.data.name || '',
                                    description: data.data.description || '',
                                    price: data.data.price || '',
                                    unit: data.data.unit || '',
                                    quantity: data.data.quantity || '',
                                    category: data.data.category || '',
                                    subcategory: data.data.subcategory || ''
                                };
                            }
                        } catch (e) {
                            console.error(e);
                        } finally {
                            this.loading = false;
                        }
                    }
                },

                async saveProduct() {
                    this.saving = true;
                    const token = localStorage.getItem('jwt_token');

                    try {
                        const url = this.productId ? `/api/products/${this.productId}` : `/api/products`;
                        const method = this.productId ? 'PUT' : 'POST';

                        const res = await fetch(url, {
                            method: method,
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        });

                        if (res.ok) {
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Succès',
                                    description: this.productId ? 'Produit mis à jour.' : 'Produit créé avec succès.',
                                    type: 'success'
                                }
                            }));
                            setTimeout(() => {
                                window.location.href = '/producer/dashboard';
                            }, 1000);
                        } else {
                            const errorData = await res.json();
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Erreur',
                                    description: errorData.message || 'Une erreur est survenue',
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