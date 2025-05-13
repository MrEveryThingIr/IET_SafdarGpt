<?php
declare(strict_types=1);

namespace App\HTMLRenderer;

use App\Helpers\JsonApi;
use RuntimeException;

class Layout implements RenderableInterface
{
    private ?Navbar $navbar;
    private ?Sidebar $sidebar;
    private array $config;

    public function __construct(?Navbar $navbar = null, ?Sidebar $sidebar = null, array $config = [])
    {
        $this->navbar  = $navbar;
        $this->sidebar = $sidebar;
        $this->config  = array_merge([
            'title'         => 'My Website',
            'stylesPaths'   => [],
            'scriptsPaths'   => [],
            'scriptHelpers' => [['name'=>'','needed_configs'=>[]]],
            'template'      => 'layouts/main_layout',
        ], $config);
    }

    public function getScriptHelpers(): array
    {
        return $this->config['scriptHelpers'] ?? [];
    }

    // public function sendJsConfigsViaJsonApi($js_config){
    //     $jsonapi=new JsonApi();
    //     $jsonapi->send($js_config);
    // }
    public function render(array $data = []): string
    {
        $view     = $data['view'] ?? '';
        $viewData = $data['viewData'] ?? [];

        $scriptHelpers = $data['scriptHelpers'] ?? $this->config['scriptHelpers'];

        $content      = $this->renderPartialWithFallback($view, $viewData);
        $navbarHtml   = $this->navbar?->render() ?? '';
        $sidebarHtml  = $this->sidebar?->render() ?? '';

        $styles = array_unique(array_merge(
            $this->config['stylesPaths'],
            $this->navbar?->getStylesPaths() ?? [],
            $this->sidebar?->getStylesPaths() ?? []
        ));

        $layoutPath = views_path($this->config['template'] . '.php');
        if (!file_exists($layoutPath)) {
            throw new RuntimeException("Layout template not found: " . $layoutPath);
        }

        ob_start();
        extract([
            'title'         => $this->config['title'],
            'stylesPaths'   => $styles,
            'scriptHelpers' => $scriptHelpers,
            'navbarHtml'    => $navbarHtml,
            'sidebarHtml'   => $sidebarHtml,
            'content'       => $content,
        ]);
        include $layoutPath;
        return ob_get_clean();
    }

    private function renderPartialWithFallback(string $view, array $viewData = []): string
    {
        $path = views_path($view . '.php');
        if (!file_exists($path)) {
            return "<div style='padding:1em;background:#fdd;color:#900'>"
                . "<strong>❌ View not found:</strong><br><code>{$path}</code>"
                . "</div>";
        }

        ob_start();
        extract($viewData);
        include $path;
        return ob_get_clean();
    }
}
