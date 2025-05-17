<?php

namespace App\Models;

use App\Core\BaseModel;

class Article extends BaseModel
{
    private string $table = 'articles';

    protected function ensureTableExist(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `author_id` INT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `slug` VARCHAR(255) UNIQUE NOT NULL,
            `field` VARCHAR(100) DEFAULT NULL COMMENT 'Category or field',
            `key_words` VARCHAR(255) DEFAULT NULL,
            `status` ENUM('draft', 'published', 'archived') DEFAULT 'draft',
            `time_to_read` SMALLINT UNSIGNED DEFAULT NULL,
            `language_code` VARCHAR(10) DEFAULT 'en',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL,
            CONSTRAINT `fk_{$this->table}_author`
                FOREIGN KEY (`author_id`) 
                REFERENCES `users` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $this->db->exec($sql);
    }

    public function create(array $data): int
    {
        if (!isset($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['title']);
        }
        return $this->insert($this->table, $data);
    }

    public function findById(int $id): ?array
    {
        return $this->fetchById($this->table, $id);
    }

    public function findBySlug(string $slug): ?array
    {
        $results = $this->search($this->table, ['slug' => $slug], [], '', [
            'limit' => 1
        ]);
        return $results[0] ?? null;
    }

    public function delete(int $id): bool
    {
        $data = ['deleted_at' => date('Y-m-d H:i:s')];
        return $this->update($this->table, $data, $id);
    }

    public function updateById(array $data, int $id): bool
    {
        return $this->update($this->table, $data, $id);
    }

    public function all($limit): array
    {
        return $this->search($this->table, ['deleted_at' => null], [], '', [
            'order_by' => 'created_at',
            'order_dir' => 'DESC',
            'limit'=> $limit
        ]);
    }

    public function getFullArticle(int $id): ?array
    {
        $article = $this->findById($id);
        if (!$article || $article['deleted_at']) {
            return null;
        }

        $blockModel = new ArticleBlock();
        $article['blocks'] = $blockModel->getBlocksForArticle($id);

        return $article;
    }

    public function searchBy(array $criteria = [], array $likeFields = [], string $likeValue = '', array $options = []): array|int
{
    $criteria['deleted_at'] = null;
    return $this->search($this->table, $criteria, $likeFields, $likeValue, $options);
}


    private function generateSlug(string $title): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    }
}
