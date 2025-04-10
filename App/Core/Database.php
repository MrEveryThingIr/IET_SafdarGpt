<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $host    = Env::get("DB_HOST", "localhost");
        $user    = Env::get("DB_USER", "root");
        $pass    = Env::get("DB_PASS", "");
        $dbName  = Env::get("DB_NAME", "test");
        $port    = Env::get("DB_PORT", "3306");
        $charset = Env::get("DB_CHARSET", "utf8mb4");

        $dsn = "mysql:host={$host};dbname={$dbName};port={$port};charset={$charset}";

        try {
            $this->connection = new PDO($dsn, $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    private function __clone() {}
    public function __wakeup() {}
}
