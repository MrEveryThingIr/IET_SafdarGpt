<?php

namespace App\Models;

use App\Core\BaseModel;

class IETAnnounce extends BaseModel
{
    private string $table = 'iet_announces';

    protected function ensureTableExist(): void
    {
        // Create the `iet_announces` table with `sub_category_id` as a foreign key
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            supply_demand ENUM('supply', 'demand') NOT NULL,
            goods_services ENUM('goods', 'services') NOT NULL,
            sub_category_id INT UNSIGNED NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            unit VARCHAR(255) NOT NULL,
            initial_suggested_price DECIMAL(10,2),
            start_date DATETIME,
            end_date DATETIME,
            location_limit VARCHAR(255),
            media_paths TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_user
                FOREIGN KEY (user_id)
                REFERENCES users(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
            CONSTRAINT fk_sub_category
                FOREIGN KEY (sub_category_id)
                REFERENCES sub_categories(id)
                ON DELETE RESTRICT
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

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

    public function getByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function specified($supply_demand = '', $keywords = [], $goods_services = '', $sub_category_id = null) 
    {
        $conditions = [];
        $params = [];

        if ($goods_services != '') {
            $conditions[] = "goods_services = :goods_services";
            $params[':goods_services'] = $goods_services;
        }
        
        if ($supply_demand != '') {
            $conditions[] = "supply_demand = :supply_demand";
            $params[':supply_demand'] = $supply_demand;
        }

        if ($sub_category_id !== null) {
            $conditions[] = "sub_category_id = :sub_category_id";
            $params[':sub_category_id'] = $sub_category_id;
        }

        if (!empty($keywords)) {
            $keywordConditions = [];
            foreach ($keywords as $key => $keyword) {
                $paramName = ":keyword_" . $key;
                $keywordConditions[] = "(
                    title LIKE $paramName 
                    OR description LIKE $paramName
                )";
                $params[$paramName] = "%" . $keyword . "%";
            }
            $conditions[] = "(" . implode(" OR ", $keywordConditions) . ")";
        }
        
        if (empty($conditions)) {
            $stmt = $this->db->query("SELECT * FROM " . $this->table);
        } else {
            $sql = "SELECT * FROM " . $this->table . " WHERE " . implode(" AND ", $conditions);
            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFilteredByUser(int $userId, array $filters = []): array
{
    $conditions = ["user_id = :user_id"];
    $params = [':user_id' => $userId];

    if (!empty($filters['goods_services'])) {
        $conditions[] = "goods_services = :goods_services";
        $params[':goods_services'] = $filters['goods_services'];
    }

    if (!empty($filters['supply_demand'])) {
        $conditions[] = "supply_demand = :supply_demand";
        $params[':supply_demand'] = $filters['supply_demand'];
    }

    if (!empty($filters['sub_category_id'])) {
        $conditions[] = "sub_category_id = :sub_category_id";
        $params[':sub_category_id'] = $filters['sub_category_id'];
    }

    if (!empty($filters['keywords']) && is_array($filters['keywords'])) {
        $keywordConditions = [];
        foreach ($filters['keywords'] as $index => $keyword) {
            $paramName = ":keyword_" . $index;
            $keywordConditions[] = "(title LIKE $paramName OR description LIKE $paramName)";
            $params[$paramName] = '%' . $keyword . '%';
        }
        $conditions[] = '(' . implode(' OR ', $keywordConditions) . ')';
    }

    $sql = "SELECT * FROM {$this->table}";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " ORDER BY created_at DESC";

    $stmt = $this->db->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}