<?php

namespace App\Helpers;

use App\Core\Database;

class Validation
{
    protected array $errors = [];
    protected $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? null;

            foreach (explode('|', $ruleSet) as $rule) {
                $params = [];

                if (str_contains($rule, ':')) {
                    [$rule, $paramStr] = explode(':', $rule);
                    $params = explode(',', $paramStr);
                }

                $method = 'validate' . ucfirst($rule);
                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $params);
                } else {
                    throw new \Exception("Validation rule {$rule} not implemented.");
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    // === Rule Handlers ===

    protected function validateRequired(string $field, $value): void
    {
        if (is_null($value) || trim($value) === '') {
            $this->addError($field, "The {$field} field is required.");
        }
    }

    protected function validateEmail(string $field, $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "The {$field} must be a valid email.");
        }
    }

    protected function validateMin(string $field, $value, array $params): void
    {
        $min = (int) $params[0];
        if (strlen($value) < $min) {
            $this->addError($field, "The {$field} must be at least {$min} characters.");
        }
    }

    protected function validateMax(string $field, $value, array $params): void
    {
        $max = (int) $params[0];
        if (strlen($value) > $max) {
            $this->addError($field, "The {$field} must be no more than {$max} characters.");
        }
    }

    protected function validateMatches(string $field, $value, array $params): void
    {
        $other = $params[0];
        if ($value !== $_POST[$other]) {
            $this->addError($field, "The {$field} must match {$other}.");
        }
    }

    protected function validateUnique(string $field, $value, array $params): void
    {
        [$table, $column] = $params;
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :value";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':value',$value);
        $result = $stmt->fetch();
        if ($result && $result['count'] > 0) {
            $this->addError($field, "The {$field} must be unique.");
        }
    }

    protected function validateXssSafe(string $field, $value): void
{
    if ($value !== htmlspecialchars($value, ENT_QUOTES, 'UTF-8')) {
        $this->addError($field, "The {$field} contains potentially unsafe characters.");
    }
}

protected function validateNoHtml(string $field, $value): void
{
    if ($value !== strip_tags($value)) {
        $this->addError($field, "The {$field} must not contain HTML.");
    }
}

protected function validateAllowedChars(string $field, $value, array $params): void
{
    $pattern = $params[0]; // e.g., '/^[a-zA-Z0-9_]+$/'
    if (!preg_match($pattern, $value)) {
        $this->addError($field, "The {$field} contains invalid characters.");
    }
}

}
