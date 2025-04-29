<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use function App\Helpers\sanitize;

class Meeting {
    private PDO $pdo;
    private string $table = 'meetings';

    public int $id;
    public int $host_id;
    public string $title;
    public string $room_code;
    public bool $is_instant = false;
    public ?string $password = null;
    public ?string $ended_at = null;

    public string $scheduled_at;
    public string $created_at;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
        $this->ensureTableExists();
    }

    /**
     * Ensure the meetings table exists.
     */
    private function ensureTableExists(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            host_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            room_code VARCHAR(100) NOT NULL,
            is_instant BOOLEAN DEFAULT FALSE,
            ended_at DATETIME DEFAULT NULL,
            password VARCHAR(255) DEFAULT NULL,
            scheduled_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (host_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB";
        $this->pdo->exec($sql);
    }

    /**
     * Store a new meeting.
     */
    public function store(): bool {
        $query = "INSERT INTO {$this->table} 
            (host_id, title, room_code, scheduled_at, is_instant, password)
            VALUES (:host_id, :title, :room_code, :scheduled_at, :is_instant, :password)";

        $stmt = $this->pdo->prepare($query);

        $this->sanitizeData();

        $stmt->bindValue(':host_id', $this->host_id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $this->title);
        $stmt->bindValue(':room_code', $this->room_code);
        $stmt->bindValue(':scheduled_at', $this->scheduled_at);
        $stmt->bindValue(':is_instant', $this->is_instant ? 1 : 0, PDO::PARAM_BOOL);
        $stmt->bindValue(':password', $this->password);

        return $stmt->execute();
    }

    /**
     * Fetch a meeting by ID.
     */
    public function fetchById(int $id): object|false {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Fetch meetings by host ID.
     */
    public function fetchByHost(int $hostId): array|false {
        $query = "SELECT * FROM {$this->table} WHERE host_id = :host_id ORDER BY scheduled_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':host_id', $hostId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: false;
    }

    /**
     * Fetch a meeting by room code.
     */
    public function fetchByRoomCode(string $roomCode): object|false {
        $query = "SELECT * FROM {$this->table} WHERE room_code = :room_code LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':room_code', $roomCode);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Update ended_at for a meeting (optional future control).
     */
    public function endMeeting(int $id): bool {
        $now = date('Y-m-d H:i:s');
        $query = "UPDATE {$this->table} SET ended_at = :ended_at WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':ended_at', $now);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Sanitize model properties.
     */
    private function sanitizeData(): void {
        $this->title = sanitize($this->title);
        $this->room_code = sanitize($this->room_code);
        $this->scheduled_at = sanitize($this->scheduled_at);
        $this->password = sanitize($this->password ?? '');
    }

    /**
     * Fill the model with DB data.
     */
    public function fill(array|object $data): void {
        foreach ((array) $data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
