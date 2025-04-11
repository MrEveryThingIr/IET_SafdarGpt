<?php
namespace App\Models\Planner;
use App\Core\BaseModel;

class MonthlyGoals extends BaseModel
{
    protected function ensureTableExist(): void
    {
                // Create monthly_goals table
        $this->db->query("
        CREATE TABLE IF NOT EXISTS monthly_goals (
            id INT AUTO_INCREMENT PRIMARY KEY,
            yearly_goal_id INT NOT NULL,
            month ENUM('فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند') NOT NULL,
            priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
            phase_category VARCHAR(100),
            phase_name VARCHAR(255),
            description TEXT,
            status ENUM('Planned', 'In Progress', 'Completed', 'Postponed') DEFAULT 'Planned',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (yearly_goal_id) REFERENCES yearly_goals(id) ON DELETE CASCADE
        )
    ");

    }

}