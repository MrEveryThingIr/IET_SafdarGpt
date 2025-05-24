<?php

namespace App\Models;

use App\Core\BaseModel;

class ChatRoom extends BaseModel
{
    private string $table = 'chat_rooms';
   
    protected function ensureTableExist(): void {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `creator_id` INT NOT NULL,
            `category_id` INT UNSIGNED NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `idx_creator` (`creator_id`),
            INDEX `idx_category` (`category_id`),
            CONSTRAINT `fk_{$this->table}_creator`
                FOREIGN KEY (`creator_id`)
                REFERENCES `users` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
            CONSTRAINT `fk_{$this->table}_category`
                FOREIGN KEY (`category_id`)
                REFERENCES `sub_categories` (`id`)
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


    public function countRoomsByUserId(int $userId): int
    {
        $sql = "SELECT COUNT(*) as total FROM chat_rooms WHERE creator_id = :user_id";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$userId]);
        $result=$stmt->fetchColumn();
        return $result[0]['total'] ?? 0;
    }

    public function getRoomsByCreatorId(int $userId): array
{
    $sql = "SELECT * FROM `{$this->table}` 
            WHERE `creator_id` = :user_id
            ORDER BY `created_at` DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


}
