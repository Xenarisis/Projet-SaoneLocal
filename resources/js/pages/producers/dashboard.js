window.producerDashboard = function() {
            return {
                loading: true,
                activeTab: 'products',
                orderFilter: 'toutes',
                expandedProduct: null,
                showAcceptModal: false,
                modalOrder: null,
                stats: {
                    producer_name: '',
                    total_sales: 0,
                    total_orders: 0,
                    total_order_items: 0,
                    total_products: 0,
                    average_cart: 0,
                    best_selling_product_name: '',
                    best_selling_product_qty: 0,
                    total_items_sold: 0,
                    new_orders_count: 0,
                    distinct_clients: 0,
                    orders_in_progress: 0,
                    orders_completed: 0,
                    orders_cancelled: 0
                },
                products: [],
                orders: [],
                
                openAcceptModal(order) {
                    this.modalOrder = JSON.parse(JSON.stringify(order));
                    // Prefill with producer's default or whatever if we had it, but we can just leave it blank or default
                    if (!this.modalOrder.pickup_location) this.modalOrder.pickup_location = '';
                    if (!this.modalOrder.pickup_date) this.modalOrder.pickup_date = '';
                    if (!this.modalOrder.pickup_time) this.modalOrder.pickup_time = '';
                    this.showAcceptModal = true;
                },

                async init() {
                    const token = localStorage.getItem('jwt_token');
                    if (!token) {
                        window.location.href = '/login';
                        return;
                    }

                    try {
                        await Promise.all([
                            this.fetchStats(token),
                            this.fetchProducts(token),
                            this.fetchOrders('toutes', token)
                        ]);
                    } catch (e) {
                        console.error('Erreur', e);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                title: 'Erreur',
                                description: 'Impossible de charger le tableau de bord.',
                                type: 'error'
                            }
                        }));
                    } finally {
                        this.loading = false;
                    }
                },

                async fetchStats(token = localStorage.getItem('jwt_token')) {
                    const res = await fetch('/api/producers/me/dashboard/stats', {
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        this.stats = await res.json();
                    }
                },

                async fetchProducts(token = localStorage.getItem('jwt_token')) {
                    const res = await fetch('/api/producers/me/dashboard/products', {
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.products = data.data; // Pagination
                    }
                },

                async fetchOrders(status = this.orderFilter, token = localStorage.getItem('jwt_token')) {
                    this.orderFilter = status;
                    let url = '/api/producers/me/dashboard/orders';
                    if (status !== 'toutes') {
                        url += '?status=' + encodeURIComponent(status);
                    }
                    const res = await fetch(url, {
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.orders = data.data; // Pagination
                    }
                },

                async updateOrderItem(id, newStatus, location = null, date = null, time = null) {
                    if (newStatus === 'en préparation') {
                        if (!location || !date || !time) {
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Erreur',
                                    description: 'Veuillez renseigner la date, l\'heure et le lieu de retrait.',
                                    type: 'error'
                                }
                            }));
                            return;
                        }
                    }

                    const token = localStorage.getItem('jwt_token');
                    try {
                        const body = { status: newStatus };
                        if (location !== null) body.pickup_location = location;
                        if (date !== null) body.pickup_date = date;
                        if (time !== null) body.pickup_time = time;
                        
                        const res = await fetch(`/api/producers/me/dashboard/orders/${id}/status`, {
                            method: 'PUT',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(body)
                        });

                        if (res.ok) {
                            // Update local state
                            const index = this.orders.findIndex(o => o.id === id);
                            if (index !== -1) {
                                const oldStatus = this.orders[index].status;
                                this.orders[index].status = newStatus;
                                if (location !== null) this.orders[index].pickup_location = location;
                                if (date !== null) this.orders[index].pickup_date = date;
                                if (time !== null) this.orders[index].pickup_time = time;
                                
                                if (oldStatus === 'nouvelle' && newStatus !== 'nouvelle') {
                                    if (this.stats.new_orders_count > 0) {
                                        this.stats.new_orders_count--;
                                    }
                                    window.dispatchEvent(new CustomEvent('producer-orders-updated', { detail: { count: this.stats.new_orders_count } }));
                                }
                            }
                            
                            this.fetchStats(token);
                            this.showAcceptModal = false;
                            
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: {
                                    title: 'Statut mis à jour',
                                    description: 'La commande a été mise à jour.',
                                    type: 'success'
                                }
                            }));
                        } else {
                            throw new Error('Update failed');
                        }
                    } catch (e) {
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                title: 'Erreur',
                                description: 'Impossible de mettre à jour la commande.',
                                type: 'error'
                            }
                        }));
                    }
                },

                async deleteProduct(id) {
                    window.dispatchEvent(new CustomEvent('open-alert', {
                        detail: {
                            title: 'Suppression du produit',
                            message: "Êtes-vous sûr de vouloir supprimer ce produit de votre catalogue ?",
                            type: 'confirm',
                            onConfirm: async () => {
                                const token = localStorage.getItem('jwt_token');
                                const res = await fetch(`/api/products/${id}`, {
                                    method: 'DELETE',
                                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                                });
                                if (res.ok) {
                                    this.products = this.products.filter(p => p.id !== id);
                                    window.dispatchEvent(new CustomEvent('notify', {
                                        detail: { title: 'Produit supprimé', type: 'success' }
                                    }));
                                }
                            }
                        }
                    }));
                }
            }
        }