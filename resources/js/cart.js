document.addEventListener('alpine:init', () => {
    Alpine.data('cart', () => ({
        items: [],
        loading: true,
        checkingOut: false,
        token: localStorage.getItem('jwt_token'),

        async init() {
            if (!this.token) {
                window.showNotification('Non connecté', 'Veuillez <a href=\"/login\" class=\"underline font-semibold\">vous connecter</a> pour voir votre panier.', 'info');
                setTimeout(() => window.location.href = '/login', 1500);
                return;
            }
            await this.fetchCart();
        },

        get totalExclTax() {
            return this.items.reduce((total, item) => total + (item.product.price * item.quantity), 0);
        },

        formatPrice(price) {
            return parseFloat(price).toFixed(2).replace('.', ',');
        },

        async fetchCart() {
            try {
                const response = await fetch('/api/cart-items', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${this.token}`
                    }
                });
                if (response.status === 401) {
                    localStorage.removeItem('jwt_token');
                    window.location.href = '/login';
                    return;
                }
                const data = await response.json();
                this.items = (data.data || []).map(item => ({...item, updating: false}));
            } catch (error) {
                console.error('Erreur:', error);
                window.showNotification('Erreur', 'Impossible de charger le panier.', 'error');
            } finally {
                this.loading = false;
            }
        },

        async updateQuantity(id, newQuantity) {
            const item = this.items.find(i => i.id === id);
            if (!item) return;

            if (newQuantity <= 0) {
                this.removeItem(id);
                return;
            }
            
            item.updating = true;
            try {
                const response = await fetch(`/api/cart-items/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${this.token}`
                    },
                    body: JSON.stringify({ quantity: newQuantity })
                });
                
                const data = await response.json();
                if (response.ok) {
                    item.quantity = newQuantity;
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } else {
                    window.showNotification('Mise à jour impossible', data.message || 'Stock insuffisant ou erreur serveur.', 'warning');
                }
            } catch (error) {
                console.error('Erreur:', error);
                window.showNotification('Erreur réseau', 'Impossible de modifier la quantité.', 'error');
            } finally {
                item.updating = false;
            }
        },

        removeItem(id) {
            window.dispatchEvent(new CustomEvent('open-alert', {
                detail: {
                    title: 'Supprimer l\'article',
                    message: 'Êtes-vous sûr de vouloir retirer cet article de votre panier ?',
                    type: 'confirm',
                    onConfirm: () => {
                        this.executeRemove(id);
                    }
                }
            }));
        },

        async executeRemove(id) {
            try {
                const response = await fetch(`/api/cart-items/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${this.token}`
                    }
                });
                
                if (response.ok) {
                    this.items = this.items.filter(i => i.id !== id);
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    window.showNotification('Succès', 'Article retiré.', 'success');
                } else {
                    const data = await response.json();
                    window.showNotification('Erreur', data.message || 'Erreur lors de la suppression.', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
            }
        },

        async checkout() {
            this.checkingOut = true;
            // Store total for the checkout page (TTC)
            localStorage.setItem('checkout_total', this.totalExclTax * 1.20);
            setTimeout(() => {
                window.location.href = '/checkout';
            }, 500);
        }
    }));
});
