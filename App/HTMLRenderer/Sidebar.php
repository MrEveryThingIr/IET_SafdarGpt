<?php
namespace App\HTMLRenderer;

class Sidebar implements RenderableInterface
{
    /**
     * Any data your sidebar needs.
     */
    private array $config;

    public function __construct(array $config = [])
    {
        $defaults = [
            'items'        => [],            // e.g. ['Dashboard', 'Settings', 'Help']
            'stylesPaths'  => [],            // e.g. ['assets/css/sidebar.css']
            'scriptsPaths' => [],            // e.g. ['assets/js/sidebar.js']
        ];

        $this->config = array_merge($defaults, $config);
    }

    public function render(array $data = []): string
    {
        // Merge any additional data
        $templateData = array_merge($this->config, $data);

        ob_start();
        extract($templateData, EXTR_SKIP);
        include views_path('sidebar.php'); // single sidebar template
        return ob_get_clean();
    }

    public function getStylesPaths(): array
    {
        return $this->config['stylesPaths'] ?? [];
    }

    public function getScriptsPaths(): array
    {
        return $this->config['scriptsPaths'] ?? [];
    }
}
