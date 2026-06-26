window.showNotification = (title, description, type = 'success') => {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { title, description, type }
    }));
};

document.addEventListener('DOMContentLoaded', () => {
    const flashNotif = sessionStorage.getItem('flash_notification');
    
    if (flashNotif) {
        const data = JSON.parse(flashNotif);
        
        setTimeout(() => {
            window.showNotification(data.title, data.description, data.type);
        }, 300);
        
        sessionStorage.removeItem('flash_notification');
    }
});