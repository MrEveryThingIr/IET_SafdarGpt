<?php
declare(strict_types=1);

namespace App\Core;

use App\HTMLRenderer\Layout;

abstract class BaseController
{
    protected Layout $layout;

    public function __construct()
    {
        $this->layout = new Layout(); // Default, override in child if needed
    }

    /**
     * Render a view using the configured Layout.
     *
     * @param string $view          View path like 'module/page'
     * @param array  $viewData      Variables passed to the view
     * @param array  $scriptHelpers Optional script helper keywords
     */
    protected function render(string $view, array $viewData = [], array $scriptHelpers = []): void
    {
        $mergedHelpers = array_unique(array_merge(
            $this->layout->getScriptHelpers(),
            $scriptHelpers
        ));

        echo $this->layout->render([
            'view'           => $view,
            'viewData'       => $viewData,
            'scriptHelpers'  => $mergedHelpers,
        ]);
    }

    protected function isLoggedIn(): bool
    {
        return isLoggedIn(); // Assumes global helper or override as needed
    }
}
