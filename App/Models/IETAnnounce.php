<?php

namespace App\Models;

use App\Core\BaseModel;

class IETAnnounce extends BaseModel
{
    private string $table = 'iet_announces';

    protected function ensureTableExist(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            supply_demand ENUM('supply', 'demand') NOT NULL,
            category VARCHAR(255) NOT NULL,
            goods_services ENUM('goods', 'services') NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            initial_suggested_price DECIMAL(10,2),
            location_limit VARCHAR(255),
            media_paths TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_user
                FOREIGN KEY (user_id) 
                REFERENCES users(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
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
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function specified($supply_demand = [], $keywords = [], $goods_services = '', $category = '') 
    {
        $conditions = [];
        $params = [];
    
        // Filter by supply/demand
        if (!empty($supply_demand)) {
            $sdConditions = [];
            foreach ((array)$supply_demand as $key => $value) {
                $paramName = ":sd_" . $key;
                $sdConditions[] = "supply_demand = " . $paramName;
                $params[$paramName] = $value;
            }
            $conditions[] = "(" . implode(" OR ", $sdConditions) . ")";
        }
    
        // Filter by goods/services
        if (!empty($goods_services)) {
            $conditions[] = "goods_services = :goods_services";
            $params[':goods_services'] = $goods_services;
        }
    
        // Search by keywords (title or description)
        if (!empty($keywords)) {
            $searchConditions = [];
            foreach ($keywords as $key => $keyword) {
                $paramTitle = ":keyword_title_" . $key;
                $paramDesc = ":keyword_desc_" . $key;
                $searchConditions[] = "(title LIKE " . $paramTitle . " OR description LIKE " . $paramDesc . ")";
                $params[$paramTitle] = "%" . $keyword . "%";
                $params[$paramDesc] = "%" . $keyword . "%";
            }
            $conditions[] = "(" . implode(" AND ", $searchConditions) . ")";
        }
    
        // Filter by category
        if (!empty($category)) {
            $conditions[] = "category LIKE :category";
            $params[':category'] = "%" . $category . "%";
        }
    
        // Build the query
        $sql = "SELECT * FROM " . $this->table;
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $sql .= " ORDER BY created_at DESC";
    
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
