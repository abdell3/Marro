<?php

/**
 * Script pour réparer le lien symbolique entre storage/app/public et public/storage
 * Exécutez ce script avec: php fix-storage-link.php
 */

echo "Réparation du lien symbolique de stockage pour Marro...\n";

// Changer vers le répertoire du projet
chdir(__DIR__);

// Vérifier si le dossier public/storage existe déjà
$publicStoragePath = __DIR__ . '/public/storage';
if (file_exists($publicStoragePath)) {
    echo "Suppression du lien symbolique existant...\n";
    
    if (is_link($publicStoragePath)) {
        // Si c'est un lien symbolique, supprimer le lien
        unlink($publicStoragePath);
    } else {
        // Si c'est un dossier, supprimer récursivement
        $it = new RecursiveDirectoryIterator($publicStoragePath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($publicStoragePath);
    }
}

// Créer un nouveau lien symbolique
echo "Création d'un nouveau lien symbolique...\n";
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Pour Windows, utiliser la commande artisan directement
    system('php artisan storage:link');
} else {
    // Pour Unix, créer le lien manuellement
    symlink(__DIR__ . '/storage/app/public', $publicStoragePath);
    echo "Lien symbolique créé: " . $publicStoragePath . " -> " . __DIR__ . '/storage/app/public' . "\n";
}

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

echo "\nRéparation terminée !\n";
echo "Votre lien symbolique de stockage devrait maintenant être fonctionnel.\n";
echo "Vous devriez maintenant pouvoir voir les avatars téléchargés sur votre site.\n";
