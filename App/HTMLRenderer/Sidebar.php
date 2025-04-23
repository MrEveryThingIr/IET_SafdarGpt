<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

use App\Helpers\View;

class Sidebar implements RenderableInterface
{
    private array $config;

    public function __construct(array $config = [])
    {
        $defaults = [
            'items'        => [],              // e.g. [ ['label'=>'Dashboard','href'=>'/dev'] , … ]
            'stylesPaths'  => [],
            'scriptsPaths' => [],
            'template'     => 'templates/sidebar_template',
        ];
        $this->config = array_merge($defaults, $config);
    }

    public function render(array $data = []): string
    {
        $payload = array_merge($this->config, $data);
        return View::renderPartial($this->config['template'], $payload);
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
