<?php
namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel {
    protected string $table = 'users';
    public $id, $firstname, $lastname, $username, $phone, $role, $main_job, $birthdate, $password, $email, $created_at, $updated_at, $gender, $img;
    
    protected function ensureTableExist(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            phone VARCHAR(15),
            email VARCHAR(255) NOT NULL UNIQUE,
            img VARCHAR(255),
            username VARCHAR(255) NOT NULL UNIQUE,
            role VARCHAR(255),
            main_job VARCHAR(255),
            password VARCHAR(255) NOT NULL,
            birthdate DATE,
            gender VARCHAR(10),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $this->db->exec($sql);
    }

    public function store(): bool {
        $data = [
            'firstname' => sanitize($this->firstname),
            'lastname' => sanitize($this->lastname),
            'phone' => sanitize_numeric($this->phone),
            'email' => sanitize_email($this->email),
            'img' => sanitize($this->img),
            'username' => sanitize_username($this->username),
            'role' => sanitize($this->role),
            'main_job' => sanitize($this->main_job),
            'password' => password_hash($this->password, PASSWORD_BCRYPT),
            'birthdate' => sanitize($this->birthdate),
            'gender' => sanitize($this->gender),
        ];
        $this->id = $this->insert($this->table, $data);
        return $this->id > 0;
    }

    public function fetchUserById(): ?array {
        return $this->fetchById($this->table, $this->id);
    }

    public function fetchAllUsers(): array|false {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: false;
    }

    public function login(): bool {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email OR username = :email");
        $email = sanitize_email($this->email);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $dbUser = $stmt->fetch(\PDO::FETCH_OBJ);
        if ($dbUser && password_verify($this->password, $dbUser->password)) {
            $this->fill($dbUser);
            return true;
        }
        return false;
    }

    public function fill(array|object $data): void {
        foreach ((array) $data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getUserAge($userId) {
        try {
            $stmt = $this->db->prepare('SELECT 
                TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age 
                FROM '.$this->table.' 
                WHERE id = :id');
            
            $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $result['age'] ?? null;
        } catch (\PDOException $e) {
            error_log("Error getting user age: " . $e->getMessage());
            return null;
        }
    }

    /**
 * Fetch user by email address.
 *
 * @param string $email
 * @return array|null
 */
public function fetchUserByEmail(string $email): ?array {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
    $sanitizedEmail = sanitize_email($email);
    $stmt->bindParam(':email', $sanitizedEmail, \PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result ?: null;
}

/**
 * Update the user's password by ID.
 *
 * @param int $userId
 * @param string $hashedPassword
 * @return bool
 */
public function updatePassword(int $userId, string $hashedPassword): bool {
    $stmt = $this->db->prepare("UPDATE {$this->table} SET password = :password, updated_at = NOW() WHERE id = :id");
    $stmt->bindParam(':password', $hashedPassword, \PDO::PARAM_STR);
    $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
    return $stmt->execute();
}

}
