<?php 
namespace App\Models\JsonModel;

class BaseJsonModel
{
    protected string $type; // e.g., 'navbars', 'forms', 'sidebars'

    protected function getBasePath(): string
    {
        return base_path("GUI_createdObjectsByUser/{$this->type}/");
    }

    protected function getFilePath(string $name): string
    {
        return $this->getBasePath() . "{$name}.json";
    }

    public function save(string $name, array $data): bool
    {
        ensure_dir($this->getBasePath());
        return file_put_contents($this->getFilePath($name), json_encode($data, JSON_PRETTY_PRINT));
    }

    public function read(string $name): ?array
    {
        $file = $this->getFilePath($name);
        return file_exists($file) ? json_decode(file_get_contents($file), true) : null;
    }

    public function delete(string $name): bool
    {
        return unlink($this->getFilePath($name));
    }

    public function list(): array
    {
        $files = glob($this->getBasePath() . '*.json');
        return array_map(fn($f) => pathinfo($f, PATHINFO_FILENAME), $files);
    }
}
