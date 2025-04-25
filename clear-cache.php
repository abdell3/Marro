<?php

/**
 * Script pour nettoyer tous les caches Laravel
 * Vous pouvez exécuter ce script avec: php clear-cache.php
 */

echo "Nettoyage des caches Laravel...\n";

// Changer vers le répertoire du projet si nécessaire
chdir(__DIR__);

// Exécuter les commandes Artisan pour nettoyer différents types de cache
echo "- Nettoyage du cache des routes...\n";
system('php artisan route:clear');

echo "- Nettoyage du cache de configuration...\n";
system('php artisan config:clear');

echo "- Nettoyage du cache d\'application...\n";
system('php artisan cache:clear');

echo "- Nettoyage du cache des vues...\n";
system('php artisan view:clear');

echo "- Nettoyage du cache de compilation...\n";
system('php artisan clear-compiled');

echo "- Optimisation des autochargements...\n";
system('composer dump-autoload -o');

echo "\nTous les caches ont été nettoyés avec succès!\n";
echo "Veuillez redémarrer votre serveur web pour que les changements prennent effet.\n";
