<?php
declare(strict_types=1);

namespace App\Core;

use App\HTMLRenderer\Layout;

abstract class BaseController
{
    protected ?Layout $layout = null;

    protected function getLayout(): Layout
    {
        if ($this->layout === null) {
            $this->layout = new Layout();
        }
        return $this->layout;
    }

    protected function render(string $view, array $viewData = [], array $scriptHelpers = []): void
    {
        $mergedHelpers = array_unique(array_merge(
            $this->getLayout()->getScriptHelpers(),
            $scriptHelpers
        ));

        echo $this->getLayout()->render([
            'view'           => $view,
            'viewData'       => $viewData,
            'scriptHelpers'  => $mergedHelpers,
        ]);
    }
}