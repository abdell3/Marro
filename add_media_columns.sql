-- Script SQL pour ajouter les colonnes media_path et media_type à la table posts

-- Vérifier si les colonnes existent déjà
SET @columnExists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'posts'
    AND COLUMN_NAME = 'media_path'
);

-- Ajouter les colonnes si elles n'existent pas
SET @sql = IF(@columnExists = 0, 
    'ALTER TABLE posts 
     ADD COLUMN media_path VARCHAR(255) NULL AFTER contenu,
     ADD COLUMN media_type VARCHAR(255) NULL AFTER media_path;',
    'SELECT "Les colonnes existent déjà dans la table posts." AS message;'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Confirmer que les colonnes existent maintenant
SELECT 
    COLUMN_NAME, 
    DATA_TYPE, 
    IS_NULLABLE, 
    COLUMN_DEFAULT
FROM 
    INFORMATION_SCHEMA.COLUMNS 
WHERE 
    TABLE_SCHEMA = DATABASE() AND 
    TABLE_NAME = 'posts' AND 
    (COLUMN_NAME = 'media_path' OR COLUMN_NAME = 'media_type');
