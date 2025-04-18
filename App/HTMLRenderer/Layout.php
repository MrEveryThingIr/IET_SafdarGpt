<?php
namespace App\HTMLRenderer;

class Layout implements RenderableInterface
{
    private ?Navbar $navbar;
    private ?Sidebar $sidebar;
    private array $config;

    public function __construct(?Navbar $navbar = null, ?Sidebar $sidebar = null, array $config = [])
    {
        $this->navbar = $navbar;
        $this->sidebar = $sidebar;

        $defaults = [
            'title'        => 'My Website',
            'stylesPaths'  => [],
            'scriptsPaths' => [],
            'layoutView'   => 'layouts/main_layout',
        ];

        $this->config = array_merge($defaults, $config);
    }

    public function render(array $data = []): string
    {
        $view      = $data['view']     ?? '';
        $viewData  = $data['viewData'] ?? [];
        


        // 1) Render the navbar
        $navbarHtml = $this->navbar ? $this->navbar->render() : '';

        // 2) Render the sidebar
        $sidebarHtml = $this->sidebar ? $this->sidebar->render() : '';

        // 3) Render the main content
        $content = '';

        if (!empty($view)) {
            $viewPath = views_path($view . '.php');

            if (file_exists($viewPath)) {
                ob_start();
                extract($viewData, EXTR_SKIP);
                include $viewPath;
                $content = ob_get_clean();
            } else {
                // ⛔ Developer-friendly error
                $content = "<div style='padding:1em;background:#fdd;color:#900;border:1px solid #f00'>
                    <strong>❌ View file not found:</strong><br>
                    <code>$viewPath</code>
                </div>";
            }
        } else {
            $content = "<p>No main view specified.</p>";
        }

        // 4) Merge all assets
        $allStyles = array_unique(array_merge(
            $this->config['stylesPaths'],
            $this->navbar?->getStylesPaths() ?? [],
            $this->sidebar?->getStylesPaths() ?? []
        ));

        $allScripts = array_unique(array_merge(
            $this->config['scriptsPaths'],
            $this->navbar?->getScriptsPaths() ?? [],
            $this->sidebar?->getScriptsPaths() ?? []
        ));

        // 5) Final layout rendering
        ob_start();
        $layoutData = [
            'title'        => $this->config['title'],
            'stylesPaths'  => $allStyles,
            'scriptsPaths' => $allScripts,
            'navbarHtml'   => $navbarHtml,
            'sidebarHtml'  => $sidebarHtml,
            'content'      => $content,
        ];
        extract($layoutData, EXTR_SKIP);

        $layoutFile = views_path($this->config['layoutView'] . '.php');
        if (!file_exists($layoutFile)) {
            return "<p>❌ Layout file not found: <code>$layoutFile</code></p>";
        }

        include $layoutFile;
        return ob_get_clean();
    }
}
