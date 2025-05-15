<?php

namespace App\Models;

use App\Core\BaseModel;

class ChatInvitees extends BaseModel
{
    private string $table = 'chat_invitees';
   
    protected function ensureTableExist(): void {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `invited_user_id` INT NOT NULL,
            `to_chatroom_id` INT NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `idx_invited_user` (`invited_user_id`),
            INDEX `idx_chatroom` (`to_chatroom_id`),
            CONSTRAINT `fk_{$this->table}_user`
                FOREIGN KEY (`invited_user_id`)
                REFERENCES `users` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
            CONSTRAINT `fk_{$this->table}_chatroom`
                FOREIGN KEY (`to_chatroom_id`)
                REFERENCES `chat_rooms` (`id`)
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

    public function countInviteesInRoomId(int $roomId): int
    {
        $sql = "SELECT COUNT(*) as total FROM chat_invitees WHERE to_chatroom_id = :room_id";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$roomId]);
        $result=$stmt->fetchColumn();
        return $result[0]['total'] ?? 0;
    }


    public function getInviteesByRoomId(int $roomId): array
    {
        $sql = "SELECT * FROM chat_invitees WHERE to_chatroom_id = :room_id";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$roomId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
