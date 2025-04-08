<?php
namespace App\Controllers;

use App\HTMLServices\LayoutService;

class HomeController
{
    private LayoutService $layoutService;

    public function __construct()
    {
        // In a real app, you might do dependency injection, 
        // but for simplicity:
        $this->layoutService = new LayoutService();
    }

    public function index()
    {
        // Just redirect for the root page:
        redirect(route('home.login'));
    }

    public function registration()
    {
        // 1) Grab a "default" layout from the LayoutService
        $layout = $this->layoutService->createDefaultLayout();

        // 2) Render the "home/register" view
        $html = $layout->render([
            'view'     => 'forms/register',
            'viewData' => [
                // pass data for registration if needed
            ]
        ]);

        echo $html;
    }

    public function login()
    {
        // 1) Also use the default layout (or create a minimal or mobile layout if you prefer)
        $layout = $this->layoutService->createAdminLayout();
        
        // 2) Render the "home/login" view
        $html = $layout->render([
            'view'     => 'forms/login',
            'viewData' => []
        ]);

        echo $html;
    }
}
