<?php

/**
 * Script complet pour résoudre les problèmes de stockage et d'avatars
 * Exécutez ce script avec: php storage-fix.php
 */

echo "==========================================\n";
echo "RÉPARATION COMPLÈTE DU STOCKAGE DE MARRO\n";
echo "==========================================\n\n";

// Changer vers le répertoire du projet
chdir(__DIR__);

// Définir les chemins importants
$storageAppPublicPath = __DIR__ . '/storage/app/public';
$publicStoragePath = __DIR__ . '/public/storage';
$avatarsPath = $storageAppPublicPath . '/avatars';

echo "ÉTAPE 1: Vérification des permissions des dossiers\n";
echo "---------------------------------------------------\n";

// Vérifier si le dossier storage/app/public existe
if (!is_dir($storageAppPublicPath)) {
    echo "Création du dossier storage/app/public...\n";
    mkdir($storageAppPublicPath, 0755, true);
} else {
    echo "Le dossier storage/app/public existe déjà.\n";
    // S'assurer que les permissions sont correctes
    chmod($storageAppPublicPath, 0755);
}

// Vérifier si le dossier avatars existe
if (!is_dir($avatarsPath)) {
    echo "Création du dossier storage/app/public/avatars...\n";
    mkdir($avatarsPath, 0755, true);
} else {
    echo "Le dossier storage/app/public/avatars existe déjà.\n";
    // S'assurer que les permissions sont correctes
    chmod($avatarsPath, 0755);
}

echo "\nÉTAPE 2: Suppression de l'ancien lien symbolique (s'il existe)\n";
echo "------------------------------------------------------------\n";

if (file_exists($publicStoragePath)) {
    echo "Suppression de l'ancien lien/dossier public/storage...\n";
    
    if (is_link($publicStoragePath)) {
        // Supprimer le lien symbolique
        if (unlink($publicStoragePath)) {
            echo "Lien symbolique supprimé avec succès.\n";
        } else {
            echo "ERREUR: Impossible de supprimer le lien symbolique.\n";
            exit(1);
        }
    } else {
        // Si c'est un dossier, le supprimer récursivement
        echo "Le chemin est un dossier, suppression récursive...\n";
        
        // Fonction récursive pour supprimer un dossier et son contenu
        function deleteDirectory($dir) {
            if (!file_exists($dir)) {
                return true;
            }
            
            if (!is_dir($dir)) {
                return unlink($dir);
            }
            
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }
                
                if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                    return false;
                }
            }
            
            return rmdir($dir);
        }
        
        if (deleteDirectory($publicStoragePath)) {
            echo "Dossier supprimé avec succès.\n";
        } else {
            echo "ERREUR: Impossible de supprimer le dossier.\n";
            exit(1);
        }
    }
} else {
    echo "Le chemin public/storage n'existe pas, aucune suppression nécessaire.\n";
}

echo "\nÉTAPE 3: Création d'un nouveau lien symbolique\n";
echo "----------------------------------------------\n";

// Créer un lien symbolique de public/storage vers storage/app/public
echo "Création du lien symbolique...\n";

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Sur Windows
    $command = 'mklink /D "' . str_replace('/', '\\', $publicStoragePath) . '" "' . 
               str_replace('/', '\\', $storageAppPublicPath) . '"';
    
    echo "Exécution de la commande: $command\n";
    
    // Exécuter la commande en mode administrateur
    $output = [];
    $returnVar = 0;
    exec($command, $output, $returnVar);
    
    echo "Résultat de la commande:\n";
    echo implode("\n", $output) . "\n";
    
    if ($returnVar !== 0) {
        echo "ERREUR: La commande a échoué avec le code $returnVar.\n";
        echo "Tentative de création du lien avec PHP artisan...\n";
        system('php artisan storage:link');
    } else {
        echo "Lien symbolique créé avec succès.\n";
    }
} else {
    // Sur Unix/Linux
    if (symlink($storageAppPublicPath, $publicStoragePath)) {
        echo "Lien symbolique créé avec succès.\n";
    } else {
        echo "ERREUR: Impossible de créer le lien symbolique.\n";
        echo "Tentative de création du lien avec PHP artisan...\n";
        system('php artisan storage:link');
    }
}

echo "\nÉTAPE 4: Vérification du lien symbolique\n";
echo "-----------------------------------------\n";

if (file_exists($publicStoragePath)) {
    if (is_link($publicStoragePath)) {
        echo "Le lien symbolique a été créé avec succès.\n";
        echo "Cible du lien: " . readlink($publicStoragePath) . "\n";
    } else {
        echo "ATTENTION: Le chemin existe mais ce n'est pas un lien symbolique.\n";
    }
} else {
    echo "ERREUR: Le lien symbolique n'a pas été créé.\n";
}

echo "\nÉTAPE 5: Vérification et mise à jour de la configuration\n";
echo "-------------------------------------------------------\n";

// Vérifier le fichier de configuration
$configFilePath = __DIR__ . '/config/filesystems.php';
$configFileContent = file_get_contents($configFilePath);

// Vérifier si la configuration du disque public pointe vers le bon dossier
if (strpos($configFileContent, "'root' => storage_path('app/public')") !== false) {
    echo "La configuration du disque public est correcte.\n";
} else {
    echo "ATTENTION: La configuration du disque public pourrait ne pas être correcte.\n";
    echo "Veuillez vérifier le fichier config/filesystems.php manuellement.\n";
}

echo "\nÉTAPE 6: Nettoyage du cache\n";
echo "---------------------------\n";

echo "Nettoyage du cache...\n";
system('php artisan cache:clear');
system('php artisan config:clear');
system('php artisan view:clear');

echo "\nÉTAPE 7: Création d'un fichier de test pour vérifier l'accès au stockage\n";
echo "----------------------------------------------------------------------\n";

$testFile = $storageAppPublicPath . '/test_storage_access.txt';
$testContent = 'Ce fichier a été créé pour tester l\'accès au stockage le ' . date('Y-m-d H:i:s');

if (file_put_contents($testFile, $testContent) !== false) {
    echo "Fichier de test créé avec succès.\n";
    echo "Vous devriez pouvoir accéder à ce fichier à l'URL suivante:\n";
    echo "http://127.0.0.1:8000/storage/test_storage_access.txt\n";
} else {
    echo "ERREUR: Impossible de créer le fichier de test.\n";
}

echo "\nÉTAPE 8: Mise à jour de la base de données pour synchroniser les avatars\n";
echo "----------------------------------------------------------------------\n";

// Vérifier si PDO est disponible
if (class_exists('PDO')) {
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
            
            echo "Tentative de connexion à la base de données...\n";
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "Connexion réussie. Récupération des utilisateurs ayant un avatar...\n";
            $stmt = $pdo->query("SELECT id, avatar FROM users WHERE avatar IS NOT NULL AND avatar != ''");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "Nombre d'utilisateurs avec avatar: " . count($users) . "\n";
            
            // Vérifier si les fichiers d'avatar existent
            foreach ($users as $user) {
                $avatarPath = $user['avatar'];
                $fullPath = $storageAppPublicPath . '/' . str_replace('avatars/', '', $avatarPath);
                
                echo "- Utilisateur ID {$user['id']}, Avatar: $avatarPath\n";
                
                if (file_exists($fullPath)) {
                    echo "  Le fichier d'avatar existe.\n";
                    
                    // S'assurer que les permissions sont correctes
                    chmod($fullPath, 0644);
                    echo "  Permissions mises à jour.\n";
                } else {
                    echo "  ATTENTION: Le fichier d'avatar n'existe pas!\n";
                }
            }
        } else {
            echo "ERREUR: Fichier .env introuvable.\n";
        }
    } catch (Exception $e) {
        echo "ERREUR lors de l'accès à la base de données: " . $e->getMessage() . "\n";
    }
} else {
    echo "PDO n'est pas disponible, impossible d'accéder à la base de données.\n";
}

echo "\n==========================================\n";
echo "RÉPARATION TERMINÉE\n";
echo "==========================================\n\n";

echo "Si tout s'est bien passé, le stockage devrait maintenant fonctionner correctement.\n";
echo "Les avatars devraient être accessibles via l'URL: http://127.0.0.1:8000/storage/avatars/[nom_du_fichier]\n\n";

echo "Pour vérifier si tout fonctionne correctement:\n";
echo "1. Accédez à votre application dans le navigateur\n";
echo "2. Essayez de télécharger un nouvel avatar\n";
echo "3. Assurez-vous que l'avatar s'affiche correctement après la mise à jour\n\n";

echo "Si les problèmes persistent, veuillez consulter les journaux d'erreurs de Laravel et du serveur web.\n";
