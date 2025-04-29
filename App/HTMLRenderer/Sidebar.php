<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

class Sidebar implements RenderableInterface
{
    private array $config;

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'items'        => [], // e.g. [ ['label'=>'Dashboard','href'=>'/dashboard'] ]
            'stylesPaths'  => [],
            'scriptsPaths' => [],
            'template'     => 'templates/sidebar_template',
        ], $config);
    }

    public function render(array $data = []): string
    {
        $payload = array_merge($this->config, $data);
        return $this->renderPartial($this->config['template'], $payload);
    }

    private function renderPartial(string $view, array $viewData = []): string
    {
        $path = views_path($view . '.php');
        if (!file_exists($path)) {
            return "<div class='text-red-600 p-4 bg-red-100'>❌ Sidebar view not found: <code>{$path}</code></div>";
        }

        ob_start();
        extract($viewData);
        include $path;
        return ob_get_clean();
    }

    public function getStylesPaths(): array
    {
        return $this->config['stylesPaths'];
    }

    public function getScriptsPaths(): array
    {
        return $this->config['scriptsPaths'];
    }
}
