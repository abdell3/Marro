/**
 * Script de secours pour gérer le menu utilisateur
 * Ce script sera chargé même si Alpine.js rencontre des problèmes
 */
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne le bouton du menu utilisateur et le menu déroulant
    const userMenuBtn = document.querySelector('.user-menu-btn');
    const userMenu = document.querySelector('.dropdown-menu');
    
    if (userMenuBtn && userMenu) {
        // Affiche/cache le menu au clic sur le bouton
        userMenuBtn.addEventListener('click', function(event) {
            event.stopPropagation(); // Empêche la propagation du clic
            
            // Vérifie si le menu est affiché
            const isDisplayed = userMenu.style.display === 'block';
            
            // Bascule l'affichage du menu
            if (isDisplayed) {
                userMenu.style.display = 'none';
            } else {
                userMenu.style.display = 'block';
            }
        });
        
        // Ferme le menu lorsqu'on clique ailleurs sur la page
        document.addEventListener('click', function(event) {
            // Si le clic n'est ni sur le bouton ni dans le menu
            if (!userMenuBtn.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.style.display = 'none';
            }
        });
        
        // Assure que les liens du menu fonctionnent
        const menuLinks = userMenu.querySelectorAll('a');
        menuLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                // Cache le menu après avoir cliqué sur un lien
                setTimeout(function() {
                    userMenu.style.display = 'none';
                }, 100);
            });
        });
    }
});
