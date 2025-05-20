<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

class Sidebar implements RenderableInterface
{
    private array $config;

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'items'         => [],
            'header'        => null,
            'footer'        => null,
            'bodyClass'     => null,
            'listClass'     => null,
            'stylesPaths'   => [],
            'scriptPaths' => [],
            'template'      => 'templates/sidebar_template',
            'defaultItemClass' => 'block p-2 rounded hover:bg-gray-700 transition-colors duration-200',
            'defaultActiveClass' => 'bg-gray-700 font-semibold',
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
        return $this->config['scriptPaths'];
    }

    public function setDefaultItemClass(string $class): self
    {
        $this->config['defaultItemClass'] = $class;
        return $this;
    }

    public function setDefaultActiveClass(string $class): self
    {
        $this->config['defaultActiveClass'] = $class;
        return $this;
    }
}