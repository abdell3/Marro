<?php

/**
 * Script pour vérifier les permissions et l'accessibilité des fichiers de stockage
 * Exécutez ce script avec: php check-storage-permissions.php
 */

echo "Vérification des permissions de stockage pour Marro...\n\n";

// Changer vers le répertoire du projet
chdir(__DIR__);

// Vérifier les chemins et permissions
$storageAppPublicPath = __DIR__ . '/storage/app/public';
$publicStoragePath = __DIR__ . '/public/storage';
$avatarsPath = $storageAppPublicPath . '/avatars';

echo "Vérification des chemins:\n";
echo "- storage/app/public: " . (is_dir($storageAppPublicPath) ? "EXISTE" : "N'EXISTE PAS") . "\n";
echo "  Permissions: " . decoct(fileperms($storageAppPublicPath) & 0777) . "\n";
echo "  Propriétaire: " . getFileOwner($storageAppPublicPath) . "\n\n";

echo "- public/storage: ";
if (file_exists($publicStoragePath)) {
    echo "EXISTE";
    if (is_link($publicStoragePath)) {
        echo " (LIEN SYMBOLIQUE)\n";
        echo "  Cible du lien: " . readlink($publicStoragePath) . "\n";
        
        // Vérifier si le lien est valide
        $target = readlink($publicStoragePath);
        if (file_exists($target)) {
            echo "  Le lien pointe vers un chemin valide.\n";
        } else {
            echo "  ERREUR: Le lien pointe vers un chemin invalide!\n";
        }
    } else {
        echo " (DOSSIER NORMAL)\n";
    }
    echo "  Permissions: " . decoct(fileperms($publicStoragePath) & 0777) . "\n";
    echo "  Propriétaire: " . getFileOwner($publicStoragePath) . "\n\n";
} else {
    echo "N'EXISTE PAS\n\n";
}

echo "- Dossier avatars: " . (is_dir($avatarsPath) ? "EXISTE" : "N'EXISTE PAS") . "\n";
if (is_dir($avatarsPath)) {
    echo "  Permissions: " . decoct(fileperms($avatarsPath) & 0777) . "\n";
    echo "  Propriétaire: " . getFileOwner($avatarsPath) . "\n\n";
    
    // Lister les fichiers dans le dossier avatars
    echo "  Fichiers dans le dossier avatars:\n";
    $files = scandir($avatarsPath);
    $hasFiles = false;
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $hasFiles = true;
            $filePath = $avatarsPath . '/' . $file;
            echo "    - $file (Taille: " . filesize($filePath) . " octets, Permissions: " . 
                decoct(fileperms($filePath) & 0777) . ", Propriétaire: " . getFileOwner($filePath) . ")\n";
                
            // Vérifier si le fichier est accessible via l'URL
            $publicPath = '/storage/avatars/' . $file;
            echo "      URL publique: " . asset($publicPath) . "\n";
            
            // Vérifier si le fichier existe dans public/storage/avatars
            $publicFilePath = $publicStoragePath . '/avatars/' . $file;
            if (file_exists($publicFilePath)) {
                echo "      Le fichier existe dans public/storage/avatars\n";
            } else {
                echo "      ERREUR: Le fichier n'existe pas dans public/storage/avatars!\n";
            }
        }
    }
    
    if (!$hasFiles) {
        echo "    Aucun fichier dans le dossier\n";
    }
}

echo "\nTests de création de fichiers:\n";

// Tester la création d'un fichier dans storage/app/public
$testFile = $storageAppPublicPath . '/test_file.txt';
$testContent = 'Test de fichier créé le ' . date('Y-m-d H:i:s');
$testResult = file_put_contents($testFile, $testContent);
echo "- Création de fichier dans storage/app/public: " . ($testResult !== false ? "RÉUSSI" : "ÉCHOUÉ") . "\n";
if ($testResult !== false) {
    echo "  Contenu écrit: $testContent\n";
    echo "  Permissions: " . decoct(fileperms($testFile) & 0777) . "\n";
    echo "  Propriétaire: " . getFileOwner($testFile) . "\n";
    @unlink($testFile); // Nettoyer
}

// Tester la création d'un fichier dans le dossier avatars
$testAvatarFile = $avatarsPath . '/test_avatar.txt';
$testContent = 'Test d\'avatar créé le ' . date('Y-m-d H:i:s');
$testResult = file_put_contents($testAvatarFile, $testContent);
echo "- Création de fichier dans le dossier avatars: " . ($testResult !== false ? "RÉUSSI" : "ÉCHOUÉ") . "\n";
if ($testResult !== false) {
    echo "  Contenu écrit: $testContent\n";
    echo "  Permissions: " . decoct(fileperms($testAvatarFile) & 0777) . "\n";
    echo "  Propriétaire: " . getFileOwner($testAvatarFile) . "\n";
    @unlink($testAvatarFile); // Nettoyer
}

echo "\nVérification terminée.\n";

/**
 * Fonction helper pour obtenir le nom du propriétaire d'un fichier
 */
function getFileOwner($path) {
    if (function_exists('posix_getpwuid')) {
        $owner = posix_getpwuid(fileowner($path));
        return $owner['name'];
    } else {
        return fileowner($path); // Retourner l'ID sur Windows
    }
}

/**
 * Fonction helper pour générer une URL asset
 */
function asset($path) {
    return 'http://127.0.0.1:8000' . $path;
}
