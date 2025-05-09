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
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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

    public function specified($supply_demand = '', $keywords = [],$goods_services='') {
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
        
        if (!empty($keywords)) {
            $categoryConditions = [];
            foreach ($keywords as $key => $keyword) {
                $paramName = ":keyword_" . $key;
                $categoryConditions[] = "category LIKE " . $paramName;
                $params[$paramName] = "%" . $keyword . "%";
            }
            $conditions[] = "(" . implode(" OR ", $categoryConditions) . ")";
        }
        
        if (empty($conditions)) {
            // No conditions, select all
            $stmt = $this->db->query("SELECT * FROM " . $this->table);
        } else {
            $sql = "SELECT * FROM " . $this->table . " WHERE " . implode(" AND ", $conditions);
            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
