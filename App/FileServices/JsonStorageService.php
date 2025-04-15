<?php 
namespace App\FileServices;

class JsonStorageService
{
    public static function store(string $type, string $name, array $config): bool
    {
        $dir = base_path("GUI_createdObjectsByUser/{$type}/");
        ensure_dir($dir);
        return file_put_contents("{$dir}{$name}.json", json_encode($config, JSON_PRETTY_PRINT));
    }

    public static function fetch(string $type, string $name): ?array
    {
        $path = base_path("GUI_createdObjectsByUser/{$type}/{$name}.json");
        return file_exists($path) ? json_decode(file_get_contents($path), true) : null;
    }

    public static function all(string $type): array
    {
        $dir = base_path("GUI_createdObjectsByUser/{$type}/");
        $files = glob("{$dir}*.json");
        return array_map(fn($f) => pathinfo($f, PATHINFO_FILENAME), $files);
    }
}
