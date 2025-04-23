<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\BaseModel;
use PDO;

class FormSubmissionModel extends BaseModel
{
    protected string $table = 'form_submissions';

    protected function ensureTableExist(): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `form_name` VARCHAR(255) NOT NULL,
          `payload` JSON NOT NULL,
          `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL;
        $this->db->exec($sql);
    }

    /**
     * Insert a new submission.
     *
     * @return int The new submission ID
     */
    public function create(string $formName, array $data): int
    {
        return $this->insert($this->table, [
            'form_name' => $formName,
            'payload'   => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);
    }

    /** Retrieve all submissions for a given form. */
    public function findByForm(string $formName): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE form_name = ?");
        $stmt->execute([$formName]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Get a single submission’s decoded payload. */
    public function getPayload(int $id): ?array
    {
        $row = $this->fetchById($this->table, $id);
        return $row ? json_decode((string)$row['payload'], true) : null;
    }
}
