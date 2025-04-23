<?php
namespace App\Models\Json;

class JsonFileModel
{
    private string $jsonDir;

    public function __construct(?string $jsonDir = null)
    {
        $this->jsonDir = $jsonDir ?? base_path('json_files/');
        if (!is_dir($this->jsonDir)) {
            mkdir($this->jsonDir, 0755, true);
        }
        
    }
    

    private function path(string $name): string
    {
        return rtrim($this->jsonDir, '/') . "/{$name}.json";
    }

    public function read(string $name): array
    {
        $file = $this->path($name);
        error_log("🔍 Reading config: {$file}");
    
        if (!file_exists($file)) {
            error_log("❌ File not found");
        }
    
        $json = file_get_contents($file);
        $parsed = json_decode($json, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("❌ JSON parse error: " . json_last_error_msg());
        }
    
        return $parsed ?? [];
    }
    
    public function write(string $name, array $data): bool
    {
        return file_put_contents($this->path($name), json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }

    public function update(string $name, array $path, mixed $value): array
    {
        $data = $this->read($name);
        $ref = &$data;

        foreach ($path as $key) {
            if (!isset($ref[$key]) || !is_array($ref[$key])) {
                $ref[$key] = [];
            }
            $ref = &$ref[$key];
        }

        $ref = $value;
        $this->write($name, $data);
        return $data;
    }

    public function updateGroup(string $name, array $updates): array
    {
        $data = $this->read($name);

        foreach ($updates as $path => $value) {
            $keys = explode('.', $path);
            $ref = &$data;

            foreach ($keys as $key) {
                if (!isset($ref[$key]) || !is_array($ref[$key])) {
                    $ref[$key] = [];
                }
                $ref = &$ref[$key];
            }

            $ref = $value;
        }

        $this->write($name, $data);
        return $data;
    }
}
