<?php

namespace App\Core;

use App\Core\Database;
use PDO;

abstract class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->db->exec("SET time_zone = '+03:30'");

        $this->ensureTableExist();

    }

    /**
     * Override in children if necessary.
     */
    protected function ensureTableExist(): void
    {
        // Optional override in child classes
    }

    protected function fetchById(string $table, int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    protected function deleteById(string $table, int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    protected function insert(string $table, array $data): int
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO {$table} ($columns) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    protected function update(string $table, array $data, int $id): bool
    {
        $set = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $this->db->prepare("UPDATE {$table} SET $set WHERE id = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function all_records(string $table): array
    {
        $stmt = $this->db->query("SELECT * FROM {$table} ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Search records with flexible conditions
 * 
 * @param array $criteria Associative array of field => value pairs for exact matches
 * @param array $likeFields Array of fields to search with LIKE operator
 * @param string $likeValue Value to search in LIKE fields (uses OR between fields)
 * @param array $options Additional options:
 *        - 'order_by' => string (field to order by)
 *        - 'order_dir' => string (ASC/DESC)
 *        - 'limit' => int
 *        - 'offset' => int
 *        - 'return_type' => string ('all' or 'count')
 * @return array|int Array of records or count depending on options
 */
public function search(string $table,array $criteria = [], array $likeFields = [], string $likeValue = '', array $options = []): array|int
{
    // Default options
    $defaultOptions = [
        'order_by' => 'id',
        'order_dir' => 'ASC',
        'limit' => null,
        'offset' => null,
        'return_type' => 'all',
        'operator' => 'AND' // Operator between criteria (AND/OR)
    ];
    $options = array_merge($defaultOptions, $options);

    $conditions = [];
    $params = [];

    // Handle exact match criteria
    foreach ($criteria as $field => $value) {
        if (is_array($value)) {
            // Handle IN clause for array values
            $placeholders = [];
            foreach ($value as $i => $val) {
                $param = ":{$field}_{$i}";
                $placeholders[] = $param;
                $params[$param] = $val;
            }
            $conditions[] = "{$field} IN (" . implode(',', $placeholders) . ")";
        } elseif ($value !== null) {
            // Handle normal equality
            $param = ":{$field}";
            $conditions[] = "{$field} = {$param}";
            $params[$param] = $value;
        }
    }

    // Handle LIKE search across multiple fields
    if (!empty($likeValue) && !empty($likeFields)) {
        $likeConditions = [];
        foreach ($likeFields as $i => $field) {
            $param = ":like_{$i}";
            $likeConditions[] = "{$field} LIKE {$param}";
            $params[$param] = "%{$likeValue}%";
        }
        $conditions[] = "(" . implode(" OR ", $likeConditions) . ")";
    }

    // Build base SQL
    $select = $options['return_type'] === 'count' ? 'COUNT(*) as count' : '*';
    $sql = "SELECT {$select} FROM {$table}";

    // Add WHERE conditions if any
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" {$options['operator']} ", $conditions);
    }

    // Add ordering if not counting
    if ($options['return_type'] !== 'count') {
        $sql .= " ORDER BY {$options['order_by']} {$options['order_dir']}";
        
        // Add limit/offset if specified
        if ($options['limit'] !== null) {
            $sql .= " LIMIT :limit";
            $params[':limit'] = (int)$options['limit'];
            
            if ($options['offset'] !== null) {
                $sql .= " OFFSET :offset";
                $params[':offset'] = (int)$options['offset'];
            }
        }
    }

    $stmt = $this->db->prepare($sql);
    
    // Bind parameters
foreach ($params as $key => $value) {
    if (in_array($key, [':limit', ':offset'])) {
        $stmt->bindValue($key, (int)$value, PDO::PARAM_INT);
    } else {
        $stmt->bindValue($key, $value);
    }
}


    $stmt->execute();

    return $options['return_type'] === 'count' 
        ? (int)$stmt->fetchColumn() 
        : $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
