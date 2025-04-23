<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

use App\Helpers\View;

class Navbar implements RenderableInterface
{
    private array $config;

    public function __construct(array $config = [])
    {
        $defaults = [
            'brand'        => 'MyApp',
            'items'        => [],              // e.g. [ ['label'=>'Home','href'=>'/'] , … ]
            'stylesPaths'  => [],
            'scriptsPaths' => [],
            'template'     => 'templates/navbar_template',
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
