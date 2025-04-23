<?php
declare(strict_types=1);

namespace App\Core;

use App\HTMLRenderer\Layout;
use App\Helpers\Url;
use App\Helpers\Session;

abstract class BaseController
{
    /**
     * @var Layout  The chrome (navbar + sidebar + template) to wrap every page.
     */
   
    protected Layout $layout;

    public function __construct()
    {
        // You might want to inject dependencies instead of hardcoding this.
        $this->layout = new Layout(); // Or inject Navbar/Sidebar if needed
    }
    /**
     * Render any view by delegating to the Layout instance.
     *
     * @param string $view    e.g. 'developer_graphical_interface/create_form'
     * @param array  $data    Variables the view expects
     */
    protected function render(string $view, array $data = []): void
    {
        // Layout::render expects ['view'=>..., 'viewData'=>...]
        echo $this->layout->render([
            'view'     => $view,
            'viewData' => $data,
        ]);
    }

    /**
     * Are we logged in?
     */
    protected function isLoggedIn(): bool
    {
        return Session::isLoggedIn();
    }
}
