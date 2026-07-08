document.addEventListener('alpine:init', () => {
    Alpine.store('favorites', {
        localProducts: JSON.parse(localStorage.getItem('favoris_products')) || [],
        localProducers: JSON.parse(localStorage.getItem('favoris_producers')) || [],
        
        dbBookmarks: [],
        dbFollows: [],
        dbBookmarksFull: [],
        dbFollowsFull: [],
        
        token: localStorage.getItem('jwt_token'),

        async init() {
            if (this.token) {
                if (this.localProducts.length > 0 || this.localProducers.length > 0) {
                    await this.syncToDb();
                } else {
                    await this.fetchFavorites();
                }
            }
        },

        async syncToDb() {
            try {
                for (const productId of this.localProducts) {
                    await fetch('/api/bookmarks', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${this.token}`
                        },
                        body: JSON.stringify({ product_id: productId })
                    });
                }
                
                for (const producerId of this.localProducers) {
                    await fetch('/api/follows', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${this.token}`
                        },
                        body: JSON.stringify({ producer_id: producerId })
                    });
                }

                this.localProducts = [];
                this.localProducers = [];
                localStorage.removeItem('favoris_products');
                localStorage.removeItem('favoris_producers');
                
                await this.fetchFavorites();
            } catch (e) {
                console.error("Erreur de synchronisation des favoris", e);
            }
        },

        async fetchFavorites() {
            if (!this.token) return;
            try {
                const prodResponse = await fetch('/api/bookmarks', {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}` }
                });
                if (prodResponse.ok) {
                    const data = await prodResponse.json();
                    this.dbBookmarksFull = data.data || [];
                    this.dbBookmarks = this.dbBookmarksFull.map(b => ({
                        id: b.id,
                        product_id: b.product_id || (b.product && b.product.id)
                    }));
                }

                const followResponse = await fetch('/api/follows', {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}` }
                });
                if (followResponse.ok) {
                    const data = await followResponse.json();
                    this.dbFollowsFull = data.data || [];
                    this.dbFollows = this.dbFollowsFull.map(f => ({
                        id: f.id,
                        producer_id: f.producer_id || (f.producer && f.producer.id)
                    }));
                }
            } catch (e) {
                console.error("Erreur de récupération des favoris", e);
            }
        },

        isProductBookmarked(id) {
            if (this.token) {
                return this.dbBookmarks.some(b => b.product_id === id);
            }
            return this.localProducts.includes(id);
        },

        isProducerFollowed(id) {
            if (this.token) {
                return this.dbFollows.some(f => f.producer_id === id);
            }
            return this.localProducers.includes(id);
        },

        async toggleProduct(id) {
            if (!this.token) {
                if (this.isProductBookmarked(id)) {
                    this.localProducts = this.localProducts.filter(p => p !== id);
                    window.showNotification('Favoris', 'Produit retiré des favoris.', 'success');
                } else {
                    this.localProducts.push(id);
                    window.showNotification('Favoris', 'Produit ajouté aux favoris. Connectez-vous pour les retrouver partout.', 'success');
                }
                localStorage.setItem('favoris_products', JSON.stringify(this.localProducts));
            } else {
                if (this.isProductBookmarked(id)) {
                    const bookmark = this.dbBookmarks.find(b => b.product_id === id);
                    if (bookmark) {
                        const res = await fetch(`/api/bookmarks/${bookmark.id}`, {
                            method: 'DELETE',
                            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}` }
                        });
                        if (res.ok) {
                            this.dbBookmarksFull = this.dbBookmarksFull.filter(b => b.id !== bookmark.id);
                            this.dbBookmarks = this.dbBookmarks.filter(b => b.id !== bookmark.id);
                            window.showNotification('Favoris', 'Produit retiré des favoris.', 'success');
                        }
                    }
                } else {
                    const res = await fetch('/api/bookmarks', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${this.token}`
                        },
                        body: JSON.stringify({ product_id: id })
                    });
                    if (res.ok) {
                        const data = await res.json();
                        if (data.data) {
                            this.dbBookmarksFull.push(data.data);
                            this.dbBookmarks.push({
                                id: data.data.id,
                                product_id: data.data.product_id || (data.data.product && data.data.product.id)
                            });
                        } else {
                             await this.fetchFavorites(); // Fallback if format is different
                        }
                        window.showNotification('Favoris', 'Produit ajouté aux favoris.', 'success');
                    }
                }
            }
        },
        
        async toggleProducer(id) {
            if (!this.token) {
                if (this.isProducerFollowed(id)) {
                    this.localProducers = this.localProducers.filter(p => p !== id);
                    window.showNotification('Abonnement', 'Vous ne suivez plus ce producteur.', 'success');
                } else {
                    this.localProducers.push(id);
                    window.showNotification('Abonnement', 'Vous suivez ce producteur. Connectez-vous pour synchroniser.', 'success');
                }
                localStorage.setItem('favoris_producers', JSON.stringify(this.localProducers));
            } else {
                if (this.isProducerFollowed(id)) {
                    const follow = this.dbFollows.find(f => f.producer_id === id);
                    if (follow) {
                        const res = await fetch(`/api/follows/${follow.id}`, {
                            method: 'DELETE',
                            headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}` }
                        });
                        if (res.ok) {
                            this.dbFollowsFull = this.dbFollowsFull.filter(f => f.id !== follow.id);
                            this.dbFollows = this.dbFollows.filter(f => f.id !== follow.id);
                            window.showNotification('Abonnement', 'Vous ne suivez plus ce producteur.', 'success');
                        }
                    }
                } else {
                    const res = await fetch('/api/follows', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${this.token}`
                        },
                        body: JSON.stringify({ producer_id: id })
                    });
                    if (res.ok) {
                        const data = await res.json();
                        if (data.data) {
                            this.dbFollowsFull.push(data.data);
                            this.dbFollows.push({
                                id: data.data.id,
                                producer_id: data.data.producer_id || (data.data.producer && data.data.producer.id)
                            });
                        } else {
                            await this.fetchFavorites();
                        }
                        window.showNotification('Abonnement', 'Vous suivez maintenant ce producteur.', 'success');
                    }
                }
            }
        }
    });
});
