import './bootstrap';

document.addEventListener("DOMContentLoaded", () => {
    const page = document.getElementById("app").dataset.page;
    
    switch (page) {
        case 'user':
            import('./user.js');
            break;
        default:
            console.warn('No script found for this page.');
    }
});
