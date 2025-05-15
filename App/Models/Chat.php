<?php

namespace App\Models;

use App\Core\BaseModel;

class Chat extends BaseModel
{
    private string $table = 'chats';
   
    protected function ensureTableExist(): void {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `sender_id` INT NOT NULL,
            `to_chatroom_id` INT,
            `key_words` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
            `chat_context` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT `fk_{$this->table}_sender`
                FOREIGN KEY (`sender_id`) 
                REFERENCES `users` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
            CONSTRAINT `fk_{$this->table}_chatroom`
                FOREIGN KEY (`to_chatroom_id`) 
                REFERENCES `chat_rooms` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC
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

    public function getMessagesByRoomId(int $roomId): array
    {
        $sql = "SELECT * FROM chats WHERE to_chatroom_id = :room_id ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$roomId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getMessagesByInvitee(int $inviteeId): array
    {
        $sql = "SELECT * FROM chats WHERE sender_id = :invitee_id ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$inviteeId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function countMessagesInRoomId(int $roomId): int
    {
        $sql = "SELECT COUNT(*) as total FROM chats WHERE to_chatroom_id = :room_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$roomId]);
        $result = $stmt->fetchColumn();
        return $result[0]['total'] ?? 0;
    }

}
