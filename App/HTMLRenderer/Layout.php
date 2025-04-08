<?php
namespace App\HTMLRenderer;

class Layout implements RenderableInterface
{
    private ?Navbar $navbar;
    private ?Sidebar $sidebar;

    /**
     * Layout-level config, e.g. its own styles/scripts, or a title, etc.
     */
    private array $config;

    public function __construct(
        ?Navbar $navbar = null,
        ?Sidebar $sidebar = null,
        array $config = []
    ) {
        $this->navbar  = $navbar;
        $this->sidebar = $sidebar;

        $defaults = [
            'title'        => 'My Website',
            'stylesPaths'  => [],  // e.g. ['assets/css/global.css']
            'scriptsPaths' => [],  // e.g. ['assets/js/global.js']
            'layoutView'   => 'layout', // the single layout file => views/layout.php
        ];

        $this->config = array_merge($defaults, $config);
    }

    public function render(array $data = []): string
    {
        /**
         * $data might have:
         *   'view' => 'home/register',   // which view file to load
         *   'viewData' => [...],         // data for that view
         * etc.
         */
        $view      = $data['view']     ?? '';  // the main content
        $viewData  = $data['viewData'] ?? [];  // data to pass to main content

        // 1) Render the navbar
        $navbarHtml = $this->navbar ? $this->navbar->render() : '';

        // 2) Render the sidebar
        $sidebarHtml = $this->sidebar ? $this->sidebar->render() : '';

        // 3) Render the main content
        ob_start();
        extract($viewData, EXTR_SKIP);
        if (!empty($view)) {
            include views_path($view . '.php');
        } else {
            echo "<p>No main view specified.</p>";
        }
        $content = ob_get_clean();

        // 4) Merge all CSS & JS
        //    Layout's + Navbar's + Sidebar's
        $allStyles  = array_merge(
            $this->config['stylesPaths'],
            $this->navbar  ? $this->navbar->getStylesPaths()  : [],
            $this->sidebar ? $this->sidebar->getStylesPaths() : []
        );
        // Remove duplicates, just in case
        $allStyles = array_unique($allStyles);

        $allScripts = array_merge(
            $this->config['scriptsPaths'],
            $this->navbar  ? $this->navbar->getScriptsPaths()  : [],
            $this->sidebar ? $this->sidebar->getScriptsPaths() : []
        );
        $allScripts = array_unique($allScripts);

        // 5) Now render the single layout template
        ob_start();
        $layoutData = [
            'title'       => $this->config['title'],
            'stylesPaths' => $allStyles,
            'scriptsPaths'=> $allScripts,
            'navbarHtml'  => $navbarHtml,
            'sidebarHtml' => $sidebarHtml,
            'content'     => $content
        ];
        extract($layoutData, EXTR_SKIP);

        // e.g. "views/layout.php"
        include views_path($this->config['layoutView'] . '.php');
        return ob_get_clean();
    }
}
