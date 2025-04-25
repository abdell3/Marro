-- Script SQL pour ajouter la colonne parent_id à la table comments

-- Vérifier si la colonne existe déjà
SET @columnExists = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'comments'
    AND COLUMN_NAME = 'parent_id'
);

-- Ajouter la colonne si elle n'existe pas
SET @sql = IF(@columnExists = 0, 
    'ALTER TABLE comments 
     ADD COLUMN parent_id BIGINT UNSIGNED NULL AFTER auteur_id,
     ADD CONSTRAINT comments_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE;',
    'SELECT "La colonne parent_id existe déjà dans la table comments." AS message;'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Confirmer que la colonne existe maintenant
SELECT 
    COLUMN_NAME, 
    DATA_TYPE, 
    IS_NULLABLE, 
    COLUMN_DEFAULT
FROM 
    INFORMATION_SCHEMA.COLUMNS 
WHERE 
    TABLE_SCHEMA = DATABASE() AND 
    TABLE_NAME = 'comments' AND 
    COLUMN_NAME = 'parent_id';
