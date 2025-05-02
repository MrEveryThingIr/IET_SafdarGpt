<?php
namespace App\Models;

use App\Core\BaseModel;

class Currency extends BaseModel {
    protected string $table = 'currencies';
    public $id, $name, $name_fa, $symbol, $ecoefficient;

    protected function ensureTableExist(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            name_fa VARCHAR(255) NOT NULL,
            symbol VARCHAR(10),
            ecoefficient DECIMAL(18,6) NOT NULL
        )";
        $this->db->exec($sql);
    }
}

class UserBalance extends BaseModel {
    protected string $table = 'user_balances';
    public $id, $user_id, $currency_id, $balance;

    protected function ensureTableExist(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            currency_id INT NOT NULL,
            balance DECIMAL(18,6) DEFAULT 0,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (currency_id) REFERENCES currencies(id) ON DELETE CASCADE,
            UNIQUE(user_id, currency_id)
        )";
        $this->db->exec($sql);
    }
}

class Transaction extends BaseModel {
    protected string $table = 'transactions';
    public $id, $sender_id, $receiver_id, $currency_id, $amount, $description;

    protected function ensureTableExist(): void {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,
            receiver_id INT NOT NULL,
            currency_id INT NOT NULL,
            amount DECIMAL(18,6) NOT NULL,
            description VARCHAR(500),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (currency_id) REFERENCES currencies(id) ON DELETE CASCADE,
            CHECK (amount > 0)
        )";
        $this->db->exec($sql);
    }
}
