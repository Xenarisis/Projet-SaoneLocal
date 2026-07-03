document.addEventListener('alpine:init', () => {
    Alpine.data('cartBadge', () => ({
        count: 0,
        token: localStorage.getItem('jwt_token'),
        async init() {
            if (this.token) {
                await this.fetchCount();
            }
        },
        async fetchCount() {
            if (!this.token) return;
            try {
                const response = await fetch('/api/cart-items', {
                    headers: { 'Authorization': `Bearer ${this.token}`, 'Accept': 'application/json' }
                });
                if (response.ok) {
                    const data = await response.json();
                    this.count = (data.data || []).reduce((acc, item) => acc + item.quantity, 0);
                } else if (response.status === 401) {
                    localStorage.removeItem('jwt_token');
                    this.token = null;
                }
            } catch(e) { console.error(e); }
        }
    }));

    Alpine.data('userMenu', () => ({
        isLoggedIn: false,
        isProducer: false,
        newOrdersCount: 0,
        async init() {
            window.addEventListener('producer-orders-updated', (e) => {
                this.newOrdersCount = e.detail.count;
            });
            const token = localStorage.getItem('jwt_token');
            if (token) {
                try {
                    const payload = JSON.parse(atob(token.split('.')[1]));
                    if (payload.exp && payload.exp * 1000 < Date.now()) {
                        localStorage.removeItem('jwt_token');
                        this.isLoggedIn = false;
                        this.isProducer = false;
                    } else {
                        this.isLoggedIn = true;
                        this.isProducer = payload.role === 'producer';
                        if (this.isProducer) {
                            await this.fetchNewOrdersCount(token);
                        }
                    }
                } catch (e) {
                    localStorage.removeItem('jwt_token');
                    this.isLoggedIn = false;
                    this.isProducer = false;
                }
            }
        },
        async fetchNewOrdersCount(token) {
            try {
                const res = await fetch('/api/producers/me/dashboard/orders?status=nouvelle', {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                if (res.ok) {
                    const data = await res.json();
                    this.newOrdersCount = data.total || 0;
                }
            } catch(e) {}
        }
    }));
});
