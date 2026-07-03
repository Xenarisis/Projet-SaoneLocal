document.addEventListener('alpine:init', () => {
    Alpine.data('addToCart', (productId) => ({
        quantity: 1,
        loading: false,
        
        async submit() {
            const token = localStorage.getItem('jwt_token');
            
            if (!token) {
                window.showNotification('Non connecté', 'Vous devez <a href=\"/login\" class=\"underline font-semibold\">être connecté</a> pour ajouter des produits au panier.', 'info');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
                return;
            }

            this.loading = true;

            try {
                const response = await fetch('/api/cart-items', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: this.quantity
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    const msg = (data.message || 'Produit ajouté au panier.') + ' <br><a href="/cart" class="underline font-bold text-emerald-700 hover:text-emerald-900 mt-1 inline-block">Voir mon panier</a>';
                    window.showNotification('Succès', msg, 'success');
                    this.quantity = 1;
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                } else {
                    window.showNotification('Erreur', data.message || 'Impossible d\'ajouter au panier.', 'error');
                }
            } catch (error) {
                console.error('Erreur lors de l\'ajout au panier:', error);
                window.showNotification('Erreur réseau', 'Impossible de contacter le serveur.', 'error');
            } finally {
                this.loading = false;
            }
        }
    }));
});
