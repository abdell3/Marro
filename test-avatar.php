<?php

/**
 * Script pour tester la fonctionnalité d'avatar
 * Exécutez ce script avec: php test-avatar.php
 */

echo "Test de la fonctionnalité d'avatar pour Marro\n\n";

// Changer vers le répertoire du projet
chdir(__DIR__);

// 1. Vérifier le lien symbolique
$publicStoragePath = __DIR__ . '/public/storage';
$storageAppPublicPath = __DIR__ . '/storage/app/public';
$avatarsPath = $storageAppPublicPath . '/avatars';

echo "1. Vérification du lien symbolique et des dossiers\n";
echo "------------------------------------------------\n";

if (file_exists($publicStoragePath)) {
    echo "- public/storage: EXISTE";
    if (is_link($publicStoragePath)) {
        $target = readlink($publicStoragePath);
        echo " (LIEN SYMBOLIQUE)\n";
        echo "  Cible du lien: " . $target . "\n";
        
        if (file_exists($target) || file_exists($storageAppPublicPath)) {
            echo "  Le lien symbolique est valide.\n";
        } else {
            echo "  ERREUR: Le lien symbolique pointe vers un chemin invalide!\n";
            echo "  Exécutez storage-fix.bat pour résoudre ce problème.\n";
        }
    } else {
        echo " (DOSSIER NORMAL - INCORRECT)\n";
        echo "  ERREUR: Ce devrait être un lien symbolique, pas un dossier normal.\n";
        echo "  Exécutez storage-fix.bat pour résoudre ce problème.\n";
    }
} else {
    echo "- public/storage: N'EXISTE PAS\n";
    echo "  ERREUR: Le lien symbolique est manquant.\n";
    echo "  Exécutez storage-fix.bat pour résoudre ce problème.\n";
}

echo "\n";
echo "- storage/app/public: ";
if (is_dir($storageAppPublicPath)) {
    echo "EXISTE\n";
} else {
    echo "N'EXISTE PAS\n";
    echo "  ERREUR: Le dossier storage/app/public est manquant.\n";
    echo "  Exécutez storage-fix.bat pour résoudre ce problème.\n";
}

echo "- storage/app/public/avatars: ";
if (is_dir($avatarsPath)) {
    echo "EXISTE\n";
} else {
    echo "N'EXISTE PAS\n";
    echo "  ERREUR: Le dossier avatars est manquant.\n";
    echo "  Exécutez storage-fix.bat pour résoudre ce problème.\n";
}

// 2. Vérifier les avatars existants dans la base de données
echo "\n2. Vérification des avatars dans la base de données\n";
echo "-----------------------------------------------\n";

try {
    // Charger les variables d'environnement pour se connecter à la base de données
    $envFile = __DIR__ . '/.env';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $envVars = [];
        
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                list($name, $value) = explode('=', $line, 2);
                $envVars[$name] = $value;
            }
        }
        
        // Établir la connexion à la base de données
        $dbHost = $envVars['DB_HOST'] ?? 'localhost';
        $dbName = $envVars['DB_DATABASE'] ?? 'marro';
        $dbUser = $envVars['DB_USERNAME'] ?? 'root';
        $dbPass = $envVars['DB_PASSWORD'] ?? '';
        
        echo "- Tentative de connexion à la base de données...\n";
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "- Connexion réussie. Récupération des utilisateurs ayant un avatar...\n";
        $stmt = $pdo->query("SELECT id, prenom, nom, avatar FROM users WHERE avatar IS NOT NULL AND avatar != ''");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "- Nombre d'utilisateurs avec avatar: " . count($users) . "\n\n";
        
        // Vérifier si les fichiers d'avatar existent
        if (count($users) > 0) {
            echo "Liste des avatars:\n";
            foreach ($users as $user) {
                $avatarPath = $user['avatar'];
                $fullPath = $storageAppPublicPath . '/' . str_replace('avatars/', '', $avatarPath);
                
                echo "- Utilisateur ID {$user['id']}, {$user['prenom']} {$user['nom']}, Avatar: $avatarPath\n";
                
                if (file_exists($fullPath)) {
                    echo "  Le fichier d'avatar existe physiquement.\n";
                    
                    // Vérifier l'URL publique
                    $publicUrl = "http://127.0.0.1:8000/storage/$avatarPath";
                    echo "  URL publique: $publicUrl\n";
                    
                    // Vérifier les permissions
                    $perms = fileperms($fullPath) & 0777;
                    echo "  Permissions: " . decoct($perms) . " (devrait être 644 ou 755)\n";
                    
                    if ($perms < 0644) {
                        echo "  ATTENTION: Les permissions peuvent être trop restrictives.\n";
                        echo "  Exécutez storage-fix.bat pour résoudre ce problème.\n";
                    }
                } else {
                    echo "  ERREUR: Le fichier d'avatar n'existe pas physiquement!\n";
                    echo "  L'utilisateur a un avatar défini dans la base de données, mais le fichier est manquant.\n";
                }
                echo "\n";
            }
        } else {
            echo "Aucun utilisateur n'a d'avatar défini dans la base de données.\n";
        }
    } else {
        echo "ERREUR: Fichier .env introuvable.\n";
    }
} catch (Exception $e) {
    echo "ERREUR lors de l'accès à la base de données: " . $e->getMessage() . "\n";
}

// 3. Tester la création d'un fichier
echo "\n3. Test de création d'un fichier dans le dossier avatars\n";
echo "---------------------------------------------------\n";

$testFile = $avatarsPath . '/test_avatar_' . time() . '.txt';
$testContent = 'Ce fichier a été créé pour tester l\'accès au dossier avatars le ' . date('Y-m-d H:i:s');

if (file_put_contents($testFile, $testContent) !== false) {
    echo "- Création de fichier test réussie.\n";
    echo "  Fichier créé: " . $testFile . "\n";
    echo "  Contenu: " . $testContent . "\n";
    
    // Vérifier l'accès public
    $relativeTestPath = 'avatars/' . basename($testFile);
    $publicTestUrl = "http://127.0.0.1:8000/storage/" . $relativeTestPath;
    echo "  URL publique pour tester l'accès: " . $publicTestUrl . "\n";
    
    // Nettoyer le fichier de test
    unlink($testFile);
    echo "  Fichier de test supprimé.\n";
} else {
    echo "ERREUR: Impossible de créer un fichier test dans le dossier avatars.\n";
    echo "Problème de permissions. Exécutez storage-fix.bat pour résoudre ce problème.\n";
}

echo "\n--------------------------------\n";
echo "RÉCAPITULATIF ET RECOMMANDATIONS\n";
echo "--------------------------------\n\n";

$hasErrors = false;

if (!file_exists($publicStoragePath) || !is_link($publicStoragePath)) {
    $hasErrors = true;
    echo "❌ Le lien symbolique public/storage est manquant ou incorrect.\n";
} else {
    echo "✅ Le lien symbolique public/storage est correct.\n";
}

if (!is_dir($avatarsPath)) {
    $hasErrors = true;
    echo "❌ Le dossier avatars est manquant.\n";
} else {
    echo "✅ Le dossier avatars existe.\n";
}

echo "\nPour résoudre tous les problèmes automatiquement, exécutez le script :\n";
echo "storage-fix.bat\n\n";

echo "Pour tester manuellement l'upload d'avatar :\n";
echo "1. Connectez-vous à votre application\n";
echo "2. Accédez à la page de modification du profil\n";
echo "3. Sélectionnez une image et cliquez sur 'Mettre à jour'\n";
echo "4. Vérifiez que l'avatar s'affiche correctement sur toutes les pages\n\n";

echo "Test terminé.\n";
