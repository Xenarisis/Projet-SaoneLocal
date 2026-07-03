import.meta.glob('./**/*.js', { eager: true });

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();