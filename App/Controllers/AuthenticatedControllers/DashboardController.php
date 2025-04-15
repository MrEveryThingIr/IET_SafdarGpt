<?php

namespace App\Controllers\AuthenticatedControllers;
use App\Controllers\AuthenticatedController;
use App\HTMLServices\LayoutService;
class DashboardController extends AuthenticatedController
{
    public function index()
    {
        $layoutService = new LayoutService();
        // 1) Also use the default layout (or create a minimal or mobile layout if you prefer)
        $layout = $layoutService->createDeveloperLayout();
        
        // 2) Render the "home/login" view
        $html = $layout->render([
            'view'     => 'developer_interface/developer_dashboard',
            'viewData' => []
        ]);

        echo $html;
    }
}
