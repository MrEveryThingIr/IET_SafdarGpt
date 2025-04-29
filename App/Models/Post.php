<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use function App\Helpers\sanitize;

class Post {
    private PDO $pdo;
    private string $table = 'posts';

    public int $id;
    public int $user_id;
    public string $title;
    public string $content;
    public string $media_type; // 'image' or 'video'
    public string $media_path;
    public string $keywords;   // comma-separated keywords
    public string $visibility = 'published'; // 'published' or 'archived'
    public string $created_at;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
        $this->ensureTableExists();
    }

    /**
     * Ensure the posts table exists.
     */
    private function ensureTableExists(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            content TEXT,
            media_type ENUM('image', 'video') NOT NULL,
            media_path VARCHAR(255) NOT NULL,
            keywords VARCHAR(255),
            visibility ENUM('published', 'archived') DEFAULT 'published',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    /**
     * Store a new post in the database.
     */
    public function store(): bool {
        $query = "INSERT INTO {$this->table} 
            (user_id, title, content, media_type, media_path, keywords, visibility)
            VALUES (:user_id, :title, :content, :media_type, :media_path, :keywords, :visibility)";

        $stmt = $this->pdo->prepare($query);
        $this->sanitizeData();

        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':media_type', $this->media_type);
        $stmt->bindParam(':media_path', $this->media_path);
        $stmt->bindParam(':keywords', $this->keywords);
        $stmt->bindParam(':visibility', $this->visibility);

        return $stmt->execute();
    }

    /**
     * Get all published posts.
     */
    public function fetchAll(): array|false {
        $query = "SELECT * FROM {$this->table} WHERE visibility = 'published' ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: false;
    }

    /**
     * Fetch a single post by ID (any visibility).
     */
    public function fetchById(int $id): object|false {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Fetch all posts by user (any visibility).
     */
    public function fetchByUser(int $userId): array|false {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: false;
    }

    /**
     * Fetch all published posts by user.
     */
    public function fetchPublishedByUser(int $userId): array|false {
        $query = "SELECT * FROM {$this->table} 
                  WHERE user_id = :user_id AND visibility = 'published' 
                  ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: false;
    }

    /**
     * Fetch all archived posts by user.
     */
    public function fetchArchivedByUser(int $userId): array|false {
        $query = "SELECT * FROM {$this->table} 
                  WHERE user_id = :user_id AND visibility = 'archived' 
                  ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: false;
    }

    /**
     * Sanitize the model's properties.
     */
    private function sanitizeData(): void {
        $this->title = sanitize($this->title);
        $this->content = sanitize($this->content);
        $this->media_type = sanitize($this->media_type);
        $this->media_path = sanitize($this->media_path);
        $this->keywords = sanitize($this->keywords);
        $this->visibility = sanitize($this->visibility);
    }

    /**
     * Map data from DB to this object.
     */
    public function fill(array|object $data): void {
        foreach ((array) $data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
