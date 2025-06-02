<?php
namespace App\Models;

use App\Core\BaseModel;

class RecoverPassword extends BaseModel {
    protected string $table = 'recover_passwords';
    public $id, $user_id, $token, $expiry, $created_at;

    protected function ensureTableExist(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expiry DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->exec($sql);
    }

    public function createResetToken(int $userId, string $hashedToken, string $expiry): bool {
        $data = [
            'user_id' => $userId,
            'token' => $hashedToken,
            'expiry' => $expiry
        ];
        $this->id = $this->insert($this->table, $data);
        return $this->id > 0;
    }

    // ✅ Use secure password_verify for matching
    public function getByToken(string $rawToken): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE expiry > NOW()");
        $stmt->execute();
        $records = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($records as $record) {
            if (password_verify($rawToken, $record['token'])) {
                return $record;
            }
        }
        return null;
    }

    public function deleteByToken(string $rawToken): bool {
        $stmt = $this->db->prepare("SELECT id, token FROM {$this->table}");
        $stmt->execute();
        $records = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($records as $record) {
            if (password_verify($rawToken, $record['token'])) {
                $deleteStmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
                $deleteStmt->bindParam(':id', $record['id']);
                return $deleteStmt->execute();
            }
        }
        return false;
    }

    public function deleteExpiredTokens(): int {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE expiry <= NOW()");
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function userHasValidToken(int $userId): bool {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE user_id = :user_id AND expiry > NOW() LIMIT 1");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function generateToken(): string {
        return bin2hex(random_bytes(32));
    }

    public function fill(array|object $data): void {
        foreach ((array) $data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
