<?php
namespace App\Models\Planner;
use App\Core\BaseModel;

class Activities extends BaseModel
{
    protected function ensureTableExist(): void
    {
// Create activities table
$this->db->query("
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    monthly_goal_id INT NOT NULL,
    activity_category VARCHAR(100),
    activity_title VARCHAR(255),
    total_time_expected INT DEFAULT 0,
    divisions_count INT DEFAULT 1,
    description TEXT,
    status ENUM('Planned', 'In Progress', 'Completed', 'Postponed') DEFAULT 'Planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (monthly_goal_id) REFERENCES monthly_goals(id) ON DELETE CASCADE
)
");

    }

}

