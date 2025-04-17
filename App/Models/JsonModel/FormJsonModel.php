<?php

namespace App\Models\JsonModel;

class FormJsonModel
{
    private string $jsonDir;

    public function __construct(?string $jsonDir = null)
    {
        $this->jsonDir = $jsonDir ?? $_SERVER['DOCUMENT_ROOT'] . '/json_files/';

        if (!is_dir($this->jsonDir)) {
            mkdir($this->jsonDir, 0755, true);
        }
    }

    private function getFilePath(string $view): string
    {
        return rtrim($this->jsonDir, '/') . "/{$view}.json";
    }

    public function getJsonArray(string $view): array
    {
        $path = $this->getFilePath($view);
        if (!file_exists($path)) return [];
        return json_decode(file_get_contents($path), true) ?? [];
    }

    public function saveJsonArray(string $view, array $data): bool
    {
        $path = $this->getFilePath($view);
        return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT)) !== false;
    }

    public function updateNestedValue(string $view, array $path, $value): array
    {
        $data = $this->getJsonArray($view);
        $ref = &$data;

        foreach ($path as $key) {
            if (!isset($ref[$key]) || !is_array($ref[$key])) {
                $ref[$key] = [];
            }
            $ref = &$ref[$key];
        }

        $ref = $value;
        $this->saveJsonArray($view, $data);
        return $data;
    }

    public function updateGroup(string $view, array $updates): array
    {
        $data = $this->getJsonArray($view);

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

        $this->saveJsonArray($view, $data);
        return $data;
    }

    public function storeConfigArray(string $view, array $config = []): bool
    {
        return $this->saveJsonArray($view, $config);
    }

    public function getConfigArray(string $view): array
    {
        return $this->getJsonArray($view);
    }
}
