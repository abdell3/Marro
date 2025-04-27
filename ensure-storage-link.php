<?php

/**
 * Script pour s'assurer que le lien symbolique du stockage est correctement configuré
 * Exécutez ce script avec: php ensure-storage-link.php
 */

echo "Vérification et configuration du lien symbolique pour Marro...\n";

// Changer vers le répertoire du projet
chdir(__DIR__);

// Vérifier si le dossier public/storage existe
$publicStoragePath = __DIR__ . '/public/storage';
$storageAppPublicPath = __DIR__ . '/storage/app/public';

echo "Vérification du lien symbolique...\n";

if (!file_exists($publicStoragePath)) {
    echo "Le lien symbolique n'existe pas. Création...\n";
    
    // Créer le lien symbolique avec Artisan
    echo shell_exec('php artisan storage:link');
    
    echo "Lien symbolique créé avec succès.\n";
} else {
    if (is_link($publicStoragePath)) {
        echo "Le lien symbolique existe déjà.\n";
    } else {
        echo "Le chemin existe mais n'est pas un lien symbolique. Suppression et recréation...\n";
        
        // Supprimer le dossier
        if (is_dir($publicStoragePath)) {
            // Fonction pour supprimer récursivement un dossier
            function removeDir($dir) {
                if (is_dir($dir)) {
                    $objects = scandir($dir);
                    foreach ($objects as $object) {
                        if ($object != "." && $object != "..") {
                            if (is_dir($dir . "/" . $object)) {
                                removeDir($dir . "/" . $object);
                            } else {
                                unlink($dir . "/" . $object);
                            }
                        }
                    }
                    rmdir($dir);
                }
            }
            
            // Supprimer le dossier
            removeDir($publicStoragePath);
        }
        
        // Créer le lien symbolique avec Artisan
        echo shell_exec('php artisan storage:link');
        
        echo "Lien symbolique recréé avec succès.\n";
    }
}

// Vérifier si le dossier storage/app/public/posts existe
$postsImagePath = $storageAppPublicPath . '/posts/images';
$postsVideoPath = $storageAppPublicPath . '/posts/videos';

if (!file_exists($postsImagePath)) {
    echo "Création du dossier pour les images des posts...\n";
    mkdir($postsImagePath, 0755, true);
}

if (!file_exists($postsVideoPath)) {
    echo "Création du dossier pour les vidéos des posts...\n";
    mkdir($postsVideoPath, 0755, true);
}

echo "Nettoyage du cache...\n";
echo shell_exec('php artisan cache:clear');
echo shell_exec('php artisan config:clear');
echo shell_exec('php artisan view:clear');

echo "Configuration terminée !\n";
