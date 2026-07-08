let isRefreshing = false;
let failedQueue = [];

const processQueue = (error, token = null) => {
    failedQueue.forEach(prom => {
        if (error) {
            prom.reject(error);
        } else {
            prom.resolve(token);
        }
    });
    failedQueue = [];
};

const originalFetch = window.fetch;

window.fetch = async function () {
    let [resource, config] = arguments;
    
    if (!config) {
        config = {};
    }

    const response = await originalFetch(resource, config);

    if (response.status === 403) {
        try {
            const clone = response.clone();
            const data = await clone.json();
            if (data.message === 'Votre compte a été suspendu par un administrateur.') {
                if (window.location.pathname !== '/ban') {
                    window.location.href = '/ban';
                }
                return response;
            }
        } catch (e) {
            // Ignore parse error
        }
    }

    if (response.status === 401 && !resource.toString().includes('/api/users/refresh') && !resource.toString().includes('/api/users/login')) {
        const token = localStorage.getItem('jwt_token');
        
        if (!token) {
            return response;
        }

        if (isRefreshing) {
            return new Promise(function(resolve, reject) {
                failedQueue.push({ resolve, reject });
            }).then(token => {
                if (config.headers instanceof Headers) {
                    config.headers.set('Authorization', 'Bearer ' + token);
                } else if (config.headers) {
                    config.headers['Authorization'] = 'Bearer ' + token;
                }
                return originalFetch(resource, config);
            }).catch(err => {
                return response;
            });
        }

        isRefreshing = true;

        try {
            const refreshResponse = await originalFetch('/api/users/refresh', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            if (refreshResponse.ok) {
                const data = await refreshResponse.json();
                const newToken = data.access_token;
                
                localStorage.setItem('jwt_token', newToken);
                
                if (config.headers instanceof Headers) {
                    config.headers.set('Authorization', 'Bearer ' + newToken);
                } else if (config.headers) {
                    config.headers['Authorization'] = 'Bearer ' + newToken;
                } else {
                    config.headers = { 'Authorization': 'Bearer ' + newToken };
                }

                processQueue(null, newToken);
                
                return await originalFetch(resource, config);
            } else {
                localStorage.removeItem('jwt_token');
                processQueue(new Error('Refresh failed'), null);
                if (window.location.pathname !== '/login') {
                    window.location.href = '/login';
                }
                return response;
            }
        } catch (err) {
            processQueue(err, null);
            return response;
        } finally {
            isRefreshing = false;
        }
    }

    return response;
};
