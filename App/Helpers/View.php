<?php
declare(strict_types=1);

namespace App\Helpers;

final class View
{
    /**
     * Resolve a view name to a .php file path.
     * e.g. 'home/index' → '/full/path/App/views/home/index.php'
     */
    public static function path(string $view): string
    {
        $rel  = 'App/views/' . ltrim($view, '/') . '.php';
        $full = base_path($rel);
        return $full;
    }

    /**
     * Render a partial view (no layout), return HTML string.
     */
    public static function renderPartial(string $view, array $data = []): string
    {
        $file = self::path($view);
        if (!is_file($file)) {
            throw new \RuntimeException("View not found: {$file}");
        }
        extract($data, EXTR_SKIP);
        ob_start();
        include $file;
        return ob_get_clean();
    }

    /**
     * Render a layout wrapping the content slot.
     * Slots: ['content'=>string, 'title'=>string, 'styles'=>[], 'scripts'=>[], ...]
     */
    public static function renderLayout(string $layout, array $slots): string
    {
        $file = self::path($layout);
        if (!is_file($file)) {
            throw new \RuntimeException("Layout not found: {$file}");
        }
        extract($slots, EXTR_SKIP);
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
