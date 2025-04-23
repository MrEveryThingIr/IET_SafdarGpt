<?php
declare(strict_types=1);

namespace App\Models\Json;

use RuntimeException;

class FormConfigModel
{
    private JsonFileModel $fs;
    private string         $dir;

    public function __construct(?string $jsonDir = null)
    {
        $this->fs  = new JsonFileModel($jsonDir);
        $this->dir = rtrim($jsonDir ?? base_path('/json_files/FormConfigs'), '/');
    }

    /** List all form config names (without “.json”). */
    public function list(): array
    {
        $files = glob($this->dir . '/*.json');
        return array_map(fn($f) => pathinfo($f, PATHINFO_FILENAME), $files);
    }

    /** Read one form config, or throw if missing. */
    public function read(string $name): array
    {
        $cfg = $this->fs->read($name);
        if (empty($cfg)) {
            throw new RuntimeException("Form config “{$name}” not found");
        }
        return $cfg;
    }

    /** Write or overwrite a form config. */
    public function write(string $name, array $config): bool
    {
        return $this->fs->write($name, $config);
    }

    /** Delete a form config JSON file. */
    public function delete(string $name): bool
    {
        $path = $this->dir . "/{$name}.json";
        if (is_file($path)) {
            return unlink($path);
        }
        return false;
    }
}
