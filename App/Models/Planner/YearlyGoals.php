<?php
namespace App\Models\Planner;
use App\Core\BaseModel;

class YearlyGoals extends BaseModel
{
    protected function ensureTableExist(): void
    {
               // Create yearly_goals table
               $this->db->query("
               CREATE TABLE IF NOT EXISTS yearly_goals (
                   id INT AUTO_INCREMENT PRIMARY KEY,
                   year INT NOT NULL,
                   goal_name VARCHAR(255) NOT NULL,
                   goal_category ENUM('Health', 'Career', 'Education', 'Finance', 'Personal Growth', 'Other') NOT NULL,
                   description TEXT,
                   status ENUM('Planned', 'In Progress', 'Completed', 'Postponed') DEFAULT 'Planned',
                   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
               )
           ");
    }

}