<?php
namespace App\Models\Planner;
use App\Core\BaseModel;

class WeeklySchedule extends BaseModel
{
    protected function ensureTableExist(): void
    {
// Create weekly_schedule table
$this->db->query("
CREATE TABLE IF NOT EXISTS weekly_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity_id INT NOT NULL,
    week_number INT NOT NULL,
    planned_time INT DEFAULT 0,
    actual_time INT DEFAULT 0,
    description TEXT,
    status ENUM('Planned', 'In Progress', 'Completed', 'Postponed') DEFAULT 'Planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
)
");


    }

}
