document.addEventListener('alpine:init', () => {
            Alpine.data('checkout', () => ({
                processing: false,
                total: localStorage.getItem('checkout_total') || 0,
                token: localStorage.getItem('jwt_token'),

                init() {
                    if(!this.total || this.total <= 0) {
                        window.location.href = '/cart';
                    }
                },

                formatPrice(price) {
                    return parseFloat(price).toFixed(2).replace('.', ',');
                },

                async processPayment(method = 'card') {
                    this.processing = true;

                    // Simulate payment delay
                    await new Promise(r => setTimeout(r, 1500));

                    try {
                        const response = await fetch('/api/orders', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${this.token}`
                            },
                            body: JSON.stringify({ payment_method: method })
                        });
                        
                        const data = await response.json();
                        if (response.ok) {
                            localStorage.removeItem('checkout_total');
                            window.showNotification('Paiement réussi', 'Votre commande a été validée avec succès !', 'success');
                            window.dispatchEvent(new CustomEvent('cart-updated')); // trigger header cart icon reset
                            setTimeout(() => {
                                window.location.href = '/orders';
                            }, 2000);
                        } else {
                            window.showNotification('Erreur', data.message || 'Erreur lors de la création de la commande.', 'error');
                            this.processing = false;
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        window.showNotification('Erreur réseau', 'Impossible de valider la commande.', 'error');
                        this.processing = false;
                    }
                }
            }));
        });