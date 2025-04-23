<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

use App\Helpers\View;
use RuntimeException;

/**
 * Layout wraps navbar, sidebar and a main view into a single page template.
 */
class Layout implements RenderableInterface
{
    private ?Navbar $navbar;
    private ?Sidebar $sidebar;
    private array   $config;

    public function __construct(?Navbar $navbar = null, ?Sidebar $sidebar = null, array $config = [])
    {
        $defaults = [
            'title'        => 'My Website',
            'stylesPaths'  => [],
            'scriptsPaths' => [],
            'template'     => 'layouts/main_layout',
        ];
        $this->navbar  = $navbar;
        $this->sidebar = $sidebar;
        $this->config  = array_merge($defaults, $config);
    }

    /**
     * Render HTML for this layout.
     *
     * @param array{
     *   view: string,
     *   viewData?: array
     * } $data
     * @return string
     */
    public function render(array $data = []): string
    {
        $view     = $data['view']     ?? '';
        $viewData = $data['viewData'] ?? [];

        // 1) Main view content
        try {
            $content = View::renderPartial($view, $viewData);
        } catch (RuntimeException $e) {
            $path    = View::path($view);
            $content = "<div style='padding:1em;background:#fdd;color:#900'>"
                     . "<strong>❌ View not found:</strong><br><code>{$path}</code>"
                     . "</div>";
        }

        // 2) Navbar & sidebar
        $navbarHtml  = $this->navbar?->render()  ?? '';
        $sidebarHtml = $this->sidebar?->render() ?? '';

        // 3) Aggregate assets
        $styles  = array_unique(array_merge(
            $this->config['stylesPaths'],
            $this->navbar?->getStylesPaths()  ?? [],
            $this->sidebar?->getStylesPaths() ?? []
        ));
        $scripts = array_unique(array_merge(
            $this->config['scriptsPaths'],
            $this->navbar?->getScriptsPaths()  ?? [],
            $this->sidebar?->getScriptsPaths() ?? []
        ));

        // 4) Wrap in layout template
        return View::renderPartial($this->config['template'], [
            'title'        => $this->config['title'],
            'stylesPaths'  => $styles,
            'scriptsPaths' => $scripts,
            'navbarHtml'   => $navbarHtml,
            'sidebarHtml'  => $sidebarHtml,
            'content'      => $content,
        ]);
    }
}
