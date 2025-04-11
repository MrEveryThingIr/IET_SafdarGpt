<?php
namespace App\Models\Planner;
use App\Core\BaseModel;

class DailySchedule extends BaseModel
{
    protected function ensureTableExist(): void
    {
        $this->db->query("
        CREATE TABLE IF NOT EXISTS daily_schedule (
            id INT AUTO_INCREMENT PRIMARY KEY,
            weekly_schedule_id INT NOT NULL,
            date DATE NOT NULL,
            planned_time INT DEFAULT 0,
            actual_time INT DEFAULT 0,
            description TEXT,
            status ENUM('Planned', 'In Progress', 'Completed', 'Missed') DEFAULT 'Planned',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (weekly_schedule_id) REFERENCES weekly_schedule(id) ON DELETE CASCADE
        )
    ");

    }

}



