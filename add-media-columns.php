<?php

/**
 * Script pour ajouter directement les colonnes media_path et media_type à la table posts
 * Ce script contourne le système de migration de Laravel en cas de problème
 */

echo "Ajout direct des colonnes média à la table posts...\n";

try {
    // Configuration de la connexion à la base de données
    $dbConfig = require __DIR__ . '/config/database.php';
    $default = $dbConfig['default'];
    $config = $dbConfig['connections'][$default];

    // Connexion à la base de données
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si les colonnes existent déjà
    $stmt = $pdo->query("SHOW COLUMNS FROM posts LIKE 'media_path'");
    $columnExists = (bool) $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$columnExists) {
        echo "Ajout des colonnes media_path et media_type à la table posts...\n";
        
        // Ajouter les colonnes
        $pdo->exec("ALTER TABLE posts ADD COLUMN media_path VARCHAR(255) NULL AFTER contenu");
        $pdo->exec("ALTER TABLE posts ADD COLUMN media_type VARCHAR(255) NULL AFTER media_path");
        
        echo "Colonnes ajoutées avec succès!\n";
    } else {
        echo "Les colonnes existent déjà dans la table posts.\n";
    }
    
    // Vérifier les dossiers de stockage
    $publicPath = __DIR__ . '/public';
    $storagePath = __DIR__ . '/storage/app/public';
    
    if (!file_exists($publicPath . '/storage')) {
        echo "Création du lien symbolique pour le stockage...\n";
        if (PHP_OS_FAMILY === 'Windows') {
            // Sur Windows, nous ne pouvons pas utiliser symlink() sans privilèges administratifs
            // Créer simplement les dossiers nécessaires
            if (!file_exists($publicPath . '/storage')) {
                mkdir($publicPath . '/storage', 0755, true);
            }
            if (!file_exists($publicPath . '/storage/posts')) {
                mkdir($publicPath . '/storage/posts', 0755, true);
            }
            if (!file_exists($publicPath . '/storage/posts/images')) {
                mkdir($publicPath . '/storage/posts/images', 0755, true);
            }
            if (!file_exists($publicPath . '/storage/posts/videos')) {
                mkdir($publicPath . '/storage/posts/videos', 0755, true);
            }
        } else {
            // Sur Unix/Linux, nous pouvons utiliser symlink()
            symlink($storagePath, $publicPath . '/storage');
        }
    }
    
    // Créer les dossiers de stockage pour les images et vidéos
    if (!file_exists($storagePath . '/posts/images')) {
        echo "Création du dossier pour les images...\n";
        mkdir($storagePath . '/posts/images', 0755, true);
    }
    
    if (!file_exists($storagePath . '/posts/videos')) {
        echo "Création du dossier pour les vidéos...\n";
        mkdir($storagePath . '/posts/videos', 0755, true);
    }
    
    echo "\nConfiguration terminée avec succès!\n";
    echo "Vous pouvez maintenant télécharger des images et des vidéos dans vos posts.\n";

} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
    exit(1);
}
