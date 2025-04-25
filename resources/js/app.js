import './bootstrap';


// Exposer Alpine globalement
window.Alpine = Alpine;

// Configuration des composants Alpine
document.addEventListener('alpine:init', () => {
    // Composant dropdown pour les menus déroulants
    Alpine.data('dropdown', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        }
    }));
});

// Démarrer Alpine.js
Alpine.start();
