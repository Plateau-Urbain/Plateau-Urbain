-- ============================================================
-- Script de rattrapage schéma BDD — MEP sécurisée
-- Plateau-Urbain — généré le 2026-05-28
--
-- IDEMPOTENT : vérifie l'existence de chaque colonne via
-- INFORMATION_SCHEMA avant tout ALTER TABLE.
-- Peut être relancé plusieurs fois sans risque.
--
-- Usage :
--   mysql -u <user> -p <base> < mep_rattrapage_schema.sql
-- ============================================================

-- Configurer le nom de la base de données
SET @dbname = DATABASE();

-- ============================================================
-- Procédure utilitaire (nettoyée après usage)
-- ============================================================
DROP PROCEDURE IF EXISTS _add_col;
DELIMITER $$
CREATE PROCEDURE _add_col(
    IN t VARCHAR(64),
    IN c VARCHAR(64),
    IN def TEXT
)
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = t AND COLUMN_NAME = c
    ) THEN
        SET @s = CONCAT('ALTER TABLE `', t, '` ADD COLUMN `', c, '` ', def);
        PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;
        SELECT CONCAT('✓ Ajouté : ', t, '.', c) AS info;
    ELSE
        SELECT CONCAT('→ Déjà présent : ', t, '.', c) AS info;
    END IF;
END$$
DELIMITER ;

-- ============================================================
-- TABLE : Space
-- ============================================================
CALL _add_col('Space', 'rolling_applications', 'TINYINT(1) NOT NULL DEFAULT 0');
CALL _add_col('Space', 'nb_spaces',            'INT DEFAULT NULL');
CALL _add_col('Space', 'min_space',             'INT DEFAULT NULL');
CALL _add_col('Space', 'max_space',             'INT DEFAULT NULL');
CALL _add_col('Space', 'societaire_message_type', 'VARCHAR(50) DEFAULT NULL');
CALL _add_col('Space', 'price_text',            'VARCHAR(255) DEFAULT NULL');
CALL _add_col('Space', 'is_erp',                'TINYINT(1) NOT NULL DEFAULT 0');

-- Mise à jour de limitAvailability : DATETIME → DATE
-- (uniquement si le type actuel est DATETIME)
SET @col_type = (
    SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'space' AND COLUMN_NAME = 'limitAvailability'
);
SET @sql_lim = IF(@col_type = 'datetime',
    'ALTER TABLE space CHANGE limitAvailability limitAvailability DATE DEFAULT NULL',
    'SELECT "→ limitAvailability déjà en DATE ou absent" AS info'
);
PREPARE stmt FROM @sql_lim; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ============================================================
-- TABLE : fos_user
-- ============================================================
CALL _add_col('fos_user', 'monthly_budget_max',       'INT DEFAULT NULL');
CALL _add_col('fos_user', 'local_usage_description',  'LONGTEXT DEFAULT NULL');
CALL _add_col('fos_user', 'preferred_departments',    "LONGTEXT DEFAULT NULL COMMENT '(DC2Type:simple_array)'");
CALL _add_col('fos_user', 'youtube_url',              'VARCHAR(255) DEFAULT NULL');
CALL _add_col('fos_user', 'tiktok_url',               'VARCHAR(255) DEFAULT NULL');

-- ============================================================
-- TABLE : Application
-- ============================================================
CALL _add_col('Application', 'local_usage_description', 'LONGTEXT DEFAULT NULL');
CALL _add_col('application', 'company_status',           'VARCHAR(64) DEFAULT NULL');

-- ============================================================
-- TABLE : use_type
-- ============================================================
CALL _add_col('use_type', 'is_active', 'TINYINT(1) NOT NULL DEFAULT 1');
UPDATE use_type SET is_active = 1 WHERE is_active IS NULL OR is_active = 0;

-- ============================================================
-- TABLE : category
-- ============================================================
CALL _add_col('category', 'is_active',    'TINYINT(1) NOT NULL DEFAULT 1');
CALL _add_col('category', 'requires_erp', 'TINYINT(1) NOT NULL DEFAULT 0');
UPDATE category SET is_active = 1 WHERE is_active IS NULL;

-- ============================================================
-- TABLE : parcel — min_surface / max_surface
-- Vérifie si surface existe encore (migration non encore passée)
-- ============================================================
SET @has_surface     = (SELECT COUNT(1) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'Parcel' AND COLUMN_NAME = 'surface');
SET @has_min_surface = (SELECT COUNT(1) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'Parcel' AND COLUMN_NAME = 'min_surface');

SET @sql_parcel = IF(@has_surface > 0 AND @has_min_surface = 0,
    'ALTER TABLE Parcel ADD COLUMN min_surface INT NOT NULL DEFAULT 0, ADD COLUMN max_surface INT NOT NULL DEFAULT 0',
    'SELECT "→ Parcel déjà migré ou surface absente" AS info'
);
PREPARE stmt FROM @sql_parcel; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql_parcel2 = IF(@has_surface > 0 AND @has_min_surface = 0,
    'UPDATE Parcel SET min_surface = surface, max_surface = surface',
    'SELECT "→ Parcel UPDATE ignoré" AS info'
);
PREPARE stmt FROM @sql_parcel2; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql_parcel3 = IF(@has_surface > 0 AND @has_min_surface = 0,
    'ALTER TABLE Parcel DROP COLUMN surface',
    'SELECT "→ Parcel DROP ignoré" AS info'
);
PREPARE stmt FROM @sql_parcel3; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ============================================================
-- TABLE : space_visit — créer si absente
-- ============================================================
CREATE TABLE IF NOT EXISTS space_visit (
    id INT AUTO_INCREMENT NOT NULL,
    space_id INT DEFAULT NULL,
    visit_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    INDEX IDX_5A6E8A9D4B3F7FB (space_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;

-- Ajouter la FK uniquement si absente
SET @fk_exists = (
    SELECT COUNT(1) FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'space_visit'
    AND CONSTRAINT_NAME = 'FK_5A6E8A9D4B3F7FB'
);
SET @sql_fk = IF(@fk_exists = 0,
    'ALTER TABLE space_visit ADD CONSTRAINT FK_5A6E8A9D4B3F7FB FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE',
    'SELECT "→ FK space_visit déjà présente" AS info'
);
PREPARE stmt FROM @sql_fk; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ============================================================
-- Nettoyage
-- ============================================================
DROP PROCEDURE IF EXISTS _add_col;

SELECT '✓ Script de rattrapage terminé.' AS resultat;
