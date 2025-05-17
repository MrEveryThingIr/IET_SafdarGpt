<?php

namespace App\Models;

use App\Core\BaseModel;

class ArticleBlock extends BaseModel
{
    private string $table = 'article_blocks';

    protected function ensureTableExist(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `article_id` INT UNSIGNED NOT NULL,
            `block_type` ENUM(
                'paragraph',
                'heading',
                'image',
                'video',
                'audio',
                'list',
                'quote',
                'embed',
                'cta',
                'faq',
                'divider'
            ) NOT NULL,
            `block_order` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
            `content` TEXT DEFAULT NULL,
            `heading_level` TINYINT UNSIGNED DEFAULT NULL,
            `image_url` VARCHAR(512) DEFAULT NULL,
            `image_alt` VARCHAR(255) DEFAULT NULL,
            `image_caption` VARCHAR(512) DEFAULT NULL,
            `list_type` ENUM('ordered', 'unordered') DEFAULT NULL,
            `css_class` VARCHAR(100) DEFAULT NULL,
            `additional_data` JSON DEFAULT NULL,
            `language_code` VARCHAR(10) DEFAULT 'en',
            `parent_block_id` INT UNSIGNED DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

    public function findById(int $id): ?array
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

    public function getBlocksForArticle(int $articleId): array
    {
        return $this->search(
            $this->table,
            ['article_id' => $articleId],
            [],
            '',
            ['order_by' => 'block_order', 'order_dir' => 'ASC']
        );
    }

    public function getByArticleId(int $articleId): array
{
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE article_id = ? ORDER BY block_order ASC");
    $stmt->execute([$articleId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function deleteByArticleId(int $articleId): bool
{
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE article_id = ?");
    return $stmt->execute([$articleId]);
}

public function getMaxOrder(int $articleId): int
{
    $stmt = $this->db->prepare("SELECT MAX(block_order) FROM {$this->table} WHERE article_id = ?");
    $stmt->execute([$articleId]);
    return (int) $stmt->fetchColumn();
}

}
