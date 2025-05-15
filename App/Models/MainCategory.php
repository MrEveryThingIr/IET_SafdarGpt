<?php

namespace App\Models;

use App\Core\BaseModel;

class MainCategory extends BaseModel
{
    private string $table = 'main_categories';
   
    protected function ensureTableExist(): void {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `cate_name` VARCHAR(255) NOT NULL,
            `description` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `idx_cate_name_unique` (`cate_name`)
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

    // public function search(): array
    // {
    //     return $this->search();
    // }

    public function getMainCategoriesWithMostSubCategories(int $limit = 5): array
    {
        // Assuming you can implement this query in your BaseModel
        $sql = "SELECT 
                    mc.id, 
                    mc.cate_name, 
                    COUNT(sc.id) as sub_category_count
                FROM main_categories mc
                LEFT JOIN sub_categories sc ON mc.id = sc.main_cate_id
                GROUP BY mc.id
                ORDER BY sub_category_count DESC
                LIMIT :limit";

        $stmt=$this->db->prepare($sql);
        $stmt->execute([$limit]);
        $result=$stmt->fetchAll();

        return $result;
    }

}
