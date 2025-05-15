<?php

namespace App\Models;

use App\Core\BaseModel;

class ArticleBlock extends BaseModel
{
    private string $table = 'article_blocks';
   
    protected function ensureTableExist(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `article_id` INT UNSIGNED NOT NULL,
            `block_type` ENUM(
                'paragraph',
                'heading',
                'image',
                'list',
                'quote',
                'embed',
                'cta',
                'faq',
                'divider'
            ) NOT NULL,
            `block_order` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
            `content` TEXT DEFAULT NULL,
            `heading_level` TINYINT UNSIGNED DEFAULT NULL COMMENT 'Heading level (2-6 for H2-H6)',
            `image_url` VARCHAR(512) DEFAULT NULL,
            `image_alt` VARCHAR(255) DEFAULT NULL,
            `image_caption` VARCHAR(512) DEFAULT NULL,
            `list_type` ENUM('ordered', 'unordered') DEFAULT NULL,
            `css_class` VARCHAR(100) DEFAULT NULL,
            `additional_data` JSON DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `idx_article_id` (`article_id`),
            INDEX `idx_block_order` (`block_order`),
            CONSTRAINT `fk_{$this->table}_article`
                FOREIGN KEY (`article_id`) 
                REFERENCES `articles` (`id`) 
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
        $this->db->exec($sql);
    }

    public function create(array $data): int
    {
        return $this->insert($this->table, $data);
    }

    public function find(int $id): ?array
    {
        return $this->fetchById($this->table, $id);
    }

    public function delete(int $id): bool
    {
        return $this->deleteById($this->table, $id);
    }

    public function updateById(array $data, int $id): bool
    {
        return $this->update($this->table, $data, $id);
    }

    
    public function all(): array
    {
        return $this->all_records($this->table);
    }

}

