<?php

namespace App\Models;

use App\Core\BaseModel;

class IETAnnounceComment extends BaseModel
{
    private string $table = 'iet_announce_comments';

    protected function ensureTableExist(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            commentor_id INT NOT NULL,
            announce_id INT NOT NULL,
            comment TEXT,
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

    public function getByAnnounceId(int $announceId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE announce_id = ? ORDER BY created_at DESC");
        $stmt->execute([$announceId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getByCommentorId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE commentor_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchCommentor($commentor_id,$feature=''){
        $commentor=new User();
        $commentor->id=$commentor_id;
        $commentor=$commentor->fetchUserById();
        if($feature!=''){
            return $commentor[$feature];
        }else{
            return $commentor;
        }
        
    }
}