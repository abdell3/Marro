<?php

/**
 * Script pour configurer la fonctionnalité d'upload de médias pour les posts
 * Exécutez ce script avec: php setup-media-upload.php
 */

echo "Configuration de la fonctionnalité d'upload de médias pour Marro...\n";

// Changer vers le répertoire du projet
chdir(__DIR__);

// Exécuter les migrations
echo "Exécution des migrations pour ajouter les colonnes media_path et media_type à la table posts...\n";
system('php artisan migrate');

// Créer le lien symbolique pour le stockage public
echo "Création du lien symbolique pour le stockage public...\n";
system('php artisan storage:link');

// Vérifier et créer les dossiers pour les médias
$imageDir = __DIR__ . '/storage/app/public/posts/images';
$videoDir = __DIR__ . '/storage/app/public/posts/videos';

if (!file_exists($imageDir)) {
    echo "Création du dossier pour les images...\n";
    mkdir($imageDir, 0755, true);
    echo "Dossier créé avec succès : $imageDir\n";
}

if (!file_exists($videoDir)) {
    echo "Création du dossier pour les vidéos...\n";
    mkdir($videoDir, 0755, true);
    echo "Dossier créé avec succès : $videoDir\n";
}

// Effacer le cache
echo "Effacement du cache...\n";
system('php artisan cache:clear');
system('php artisan config:clear');
system('php artisan view:clear');

echo "\nConfiguration terminée !\n";
echo "Vous pouvez maintenant télécharger des images et des vidéos dans vos posts.\n";
echo "Instructions :\n";
echo "1. Accédez à la page de création de post\n";
echo "2. Sélectionnez le type de contenu 'Image' ou 'Vidéo'\n";
echo "3. Téléchargez votre fichier et ajoutez une description (facultative)\n";
echo "4. Publiez votre post\n";
