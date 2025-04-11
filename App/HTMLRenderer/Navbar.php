<?php
namespace App\HTMLRenderer;

class Navbar implements RenderableInterface
{
    /**
     * Any data your navbar needs: brand, items, styles, scripts, etc.
     */
    private array $config;

    public function __construct(array $config = [])
    {
        // Default config if you want fallback values:
        $defaults = [
            'brand'        => 'MyApp',
            'items'        => [],            // e.g. ['Home' => '/home', 'About' => '/about']
            'stylesPaths'  => [],            // e.g. ['assets/css/navbar.css']
            'scriptsPaths' => [],            // e.g. ['assets/js/navbar.js']
        ];

        $this->config = array_merge($defaults, $config);
    }

    public function render(array $data = []): string
    {
        // Merge any runtime data with constructor config:
        $templateData = array_merge($this->config, $data);

        // We want to pass $templateData to navbar.php
        ob_start();
        extract($templateData, EXTR_SKIP);
        include views_path('molecules/navbar.php'); // single navbar template
        return ob_get_clean();
    }

    /**
     * So the Layout can collect the extra CSS or JS from this Navbar.
     */
    public function getStylesPaths(): array
    {
        return $this->config['stylesPaths'] ?? [];
    }

    public function getScriptsPaths(): array
    {
        return $this->config['scriptsPaths'] ?? [];
    }
}
