<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Json\FormConfigModel;

class FormConfigService
{
    private FormConfigModel $configs;

    public function __construct()
    {
        $this->configs = new FormConfigModel();
    }

    public function listForms(): array
    {
        return $this->configs->list();
    }

    public function getConfig(string $name): array
    {
        return $this->configs->read($name);
    }

    public function saveConfig(string $name, array $config): bool
    {
        return $this->configs->write($name, $config);
    }

    public function deleteConfig(string $name): bool
    {
        return $this->configs->delete($name);
    }
}
