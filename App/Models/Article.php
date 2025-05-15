<?php

namespace App\Models;

use App\Core\BaseModel;

class Article extends BaseModel
{
    private string $table = 'articles';
   
    protected function ensureTableExist(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            author_id INT UNSIGNED NOT NULL,
            title VARCHAR(255) NOT NULL,
            key_words VARCHAR(255) NULL,
            time_to_read SMALLINT UNSIGNED NULL COMMENT 'Reading time in minutes',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_{$this->table}_author
                FOREIGN KEY (author_id) 
                REFERENCES users(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
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
        return $this->all_records($this->table);
    }

}
