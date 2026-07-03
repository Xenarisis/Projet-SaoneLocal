document.addEventListener('alpine:init', () => {
    Alpine.data('orders', () => ({
        items: [],
        loading: true,
        token: localStorage.getItem('jwt_token'),

        async init() {
            if (!this.token) {
                window.showNotification('Non connecté', 'Veuillez <a href=\"/login\" class=\"underline font-semibold\">vous connecter</a> pour voir vos commandes.', 'info');
                setTimeout(() => window.location.href = '/login', 1500);
                return;
            }
            await this.fetchOrders();
        },

        formatPrice(price) {
            return parseFloat(price).toFixed(2).replace('.', ',');
        },

        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit' };
            return new Date(dateString).toLocaleDateString('fr-FR', options);
        },

        computedOrderStatus(order) {
            if (order.status === 'processing' && order.items && order.items.length > 0) {
                const allReadyOrDone = order.items.every(item => ['prête', 'retirée', 'annulée'].includes(item.status));
                const anyReady = order.items.some(item => item.status === 'prête');
                if (allReadyOrDone && anyReady) {
                    return 'ready';
                }
            }
            return order.status;
        },

        translateStatus(status) {
            const translations = {
                'pending': 'En attente',
                'processing': 'En cours',
                'ready': 'Prête à retirer',
                'completed': 'Terminée',
                'cancelled': 'Annulée'
            };
            return translations[status] || status;
        },

        translateItemStatus(status) {
            const translations = {
                'nouvelle': 'En attente',
                'en préparation': 'En préparation',
                'prête': 'Prête à retirer',
                'retirée': 'Retirée',
                'annulée': 'Annulée'
            };
            return translations[status] || status;
        },

        async fetchOrders() {
            try {
                const response = await fetch('/api/orders', {
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
                this.items = data.data || [];
            } catch (error) {
                console.error('Erreur:', error);
                window.showNotification('Erreur', 'Impossible de charger vos commandes.', 'error');
            } finally {
                this.loading = false;
            }
        },

        async cancelOrder(orderId) {
            if(!confirm('Êtes-vous sûr de vouloir annuler cette commande ?')) return;

            try {
                const response = await fetch(`/api/orders/${orderId}`, {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${this.token}`
                    },
                    body: JSON.stringify({ status: 'cancelled' })
                });
                
                if (response.ok) {
                    const orderIndex = this.items.findIndex(o => o.id === orderId);
                    if(orderIndex !== -1) {
                        this.items[orderIndex].status = 'cancelled';
                    }
                    window.showNotification('Commande annulée', 'Votre commande a été annulée et vous avez été remboursé.', 'success');
                } else {
                    window.showNotification('Erreur', 'Impossible d\'annuler la commande.', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                window.showNotification('Erreur réseau', 'Impossible de contacter le serveur.', 'error');
            }
        }
    }));
});