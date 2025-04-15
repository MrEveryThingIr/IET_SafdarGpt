<?php

function list_json_components(string $folder): array
{
    $directory = base_path("GUI_createdObjectsByUser/{$folder}/");
    if (!is_dir($directory)) {
        return [];
    }

    $files = scandir($directory);
    $list = [];

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $list[$file] = ucfirst(str_replace('_', ' ', $name));
        }
    }

    return $list;
}

function ensure_dir($dir)
{
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}
