<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use function App\Helpers\sanitize;
use function App\Helpers\sanitize_email;
use function App\Helpers\sanitize_username;
use function App\Helpers\sanitize_numeric;

class User {
    private $pdo;
    private $table = 'users';
    public $id, $firstname, $lastname, $username, $phone, $role, $main_job, $birthdate, $password, $email, $created_at, $updated_at, $gender, $img;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
        $this->ensureTableExists();
    }

    private function ensureTableExists() {
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
        )";
        $this->pdo->exec($sql);
    }

    public function store(): bool {
        $query = "INSERT INTO {$this->table} (firstname, lastname, phone, email, img, username, role, main_job, password, birthdate, gender)
                  VALUES (:firstname, :lastname, :phone, :email, :img, :username, :role, :main_job, :password, :birthdate, :gender)";
        
        $stmt = $this->pdo->prepare($query);
    
        $this->sanitizeData();
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
    
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":img", $this->img);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":main_job", $this->main_job);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":birthdate", $this->birthdate);
        $stmt->bindParam(":gender", $this->gender);
    
        $success = $stmt->execute();
    
        if ($success) {
            $this->id = (int) $this->pdo->lastInsertId();  // 🔥 This fixes the problem
        }
    
        return $success;
    }
    

    public function fetchUserById() {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAllUsers(){
        $query = "SELECT * FROM ".$this->table;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: false;
    }

    public function login() {
        $query = "SELECT * FROM {$this->table} WHERE email = :email OR username = :email";
        $stmt = $this->pdo->prepare($query);
        $email = sanitize_email($this->email);

        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $dbUser = $stmt->fetch(PDO::FETCH_OBJ);

        if ($dbUser && password_verify($this->password, $dbUser->password)) {
            $this->fill($dbUser);
            return true;
        }
        return false;
    }

    private function sanitizeData() {
        $this->firstname = sanitize($this->firstname);
        $this->lastname = sanitize($this->lastname);
        $this->username = sanitize_username($this->username);
        $this->phone = sanitize_numeric($this->phone);
        $this->role = sanitize($this->role);
        $this->main_job = sanitize($this->main_job);
        $this->birthdate = sanitize($this->birthdate);
        $this->email = sanitize_email($this->email);
        $this->gender = sanitize($this->gender);
        $this->img = sanitize($this->img);
    }

    public function fill(array|object $data): void
    {
        foreach ((array) $data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
