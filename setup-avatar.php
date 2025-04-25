<?php

/**
 * Script pour configurer la fonctionnalité d'avatar et de préférences utilisateur
 * Exécutez ce script avec: php setup-avatar.php
 */

echo "Configuration des fonctionnalités utilisateur pour Marro...\n";

// Changer vers le répertoire du projet
chdir(__DIR__);

// Exécuter les migrations
echo "Exécution des migrations pour ajouter les colonnes avatar et preferences...\n";
system('php artisan migrate');

// Créer le lien symbolique pour le stockage
echo "Création du lien symbolique pour le stockage...\n";
system('php artisan storage:link');

// Vérifier si le dossier avatars existe dans le stockage public, sinon le créer
$avatarsDir = __DIR__ . '/storage/app/public/avatars';
if (!file_exists($avatarsDir)) {
    echo "Création du dossier avatars dans le stockage...\n";
    mkdir($avatarsDir, 0755, true);
    echo "Dossier créé avec succès : $avatarsDir\n";
}

// Effacer le cache
echo "Effacement du cache...\n";
system('php artisan cache:clear');
system('php artisan config:clear');
system('php artisan view:clear');

echo "\nConfiguration terminée !\n";
echo "Vous pouvez maintenant télécharger et utiliser des avatars dans votre application Marro.\n";
echo "Instructions :\n";
echo "1. Connectez-vous à votre compte\n";
echo "2. Accédez au menu utilisateur (cliquez sur votre nom en haut à droite)\n";
echo "3. Cliquez sur 'Modifier Avatar'\n";
echo "4. Sélectionnez une image et cliquez sur 'Mettre à jour'\n";
echo "5. Votre avatar devrait maintenant s'afficher dans le menu utilisateur et sur votre profil\n";

