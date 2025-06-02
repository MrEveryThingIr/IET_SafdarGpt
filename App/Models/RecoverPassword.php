<?php
namespace App\Models;

use App\Core\BaseModel;

class RecoverPassword extends BaseModel {
    protected string $table = 'recover_passwords';
    public $id, $user_id, $token, $expiry, $created_at;

    /**
     * Ensure the password_resets table exists in the database.
     */
    protected function ensureTableExist(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            token VARCHAR(255) NOT NULL UNIQUE,
            expiry DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->exec($sql);
    }

    /**
     * Create a new password reset token for a user.
     *
     * @param int $userId
     * @param string $token
     * @param string $expiry
     * @return bool
     */
    public function createResetToken(int $userId, string $token, string $expiry): bool {
        $data = [
            'user_id' => $userId,
            'token' => $token,
            'expiry' => $expiry
        ];
        $this->id = $this->insert($this->table, $data);
        return $this->id > 0;
    }

    /**
     * Retrieve a password reset record by token.
     *
     * @param string $token
     * @return array|null
     */
    public function getByToken(string $token): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE token = :token AND expiry > NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Delete a password reset record by token.
     *
     * @param string $token
     * @return bool
     */
    public function deleteByToken(string $token): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE token = :token");
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    /**
     * Delete all expired tokens from the table.
     *
     * @return int The number of rows deleted.
     */
    public function deleteExpiredTokens(): int {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE expiry <= NOW()");
        $stmt->execute();
        return $stmt->rowCount();
    }

    /**
     * Check if a valid reset token exists for a user.
     *
     * @param int $userId
     * @return bool
     */
    public function userHasValidToken(int $userId): bool {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE user_id = :user_id AND expiry > NOW() LIMIT 1");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return (bool) $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Generate a secure random token.
     *
     * @return string
     */
    public static function generateToken(): string {
        return bin2hex(random_bytes(32));
    }

    /**
     * Fill the model properties with an array or object of data.
     *
     * @param array|object $data
     */
    public function fill(array|object $data): void {
        foreach ((array) $data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}