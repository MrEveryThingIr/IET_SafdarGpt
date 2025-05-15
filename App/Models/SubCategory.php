<?php

namespace App\Models;

use App\Core\BaseModel;

class SubCategory extends BaseModel
{
    private string $table = 'sub_categories';
   
    protected function ensureTableExist(): void {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `main_cate_id` INT UNSIGNED NOT NULL,
            `cate_name` VARCHAR(255) NOT NULL,
            `key_words` VARCHAR(255) DEFAULT NULL,
            `description` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `idx_{$this->table}_cate_name` (`cate_name`),
            INDEX `idx_{$this->table}_main_cate` (`main_cate_id`),
            CONSTRAINT `fk_{$this->table}_main_cate`
                FOREIGN KEY (`main_cate_id`)
                REFERENCES `main_categories` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL;
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

    public function findByMainCategory(int $mainCategoryId): array
{
    $sql = "SELECT * FROM {$this->table} WHERE main_cate_id = :main_cate_id ORDER BY cate_name ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['main_cate_id' => $mainCategoryId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

public function getStatsByMainCategory(int $mainCategoryId): array
{
    $sql = "SELECT 
                main_cate_id, 
                COUNT(*) as total_subcategories,
                GROUP_CONCAT(cate_name) as subcategory_names
            FROM {$this->table} 
            WHERE main_cate_id = :main_cate_id
            GROUP BY main_cate_id";
    return $this->db->prepare($sql)->fetch(\PDO::FETCH_ASSOC);
}

}
