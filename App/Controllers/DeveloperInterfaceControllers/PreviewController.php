<?php

namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;
use App\FileServices\JsonStorageService;
use App\HTMLServices\LayoutService;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;

class PreviewController extends BaseController
{
    public function index()
    {
        $layoutName = $_GET['layout'] ?? null;

        if (!$layoutName) {
            echo "<p>No layout selected.</p>";
            return;
        }

        $layoutConfig = JsonStorageService::fetch('layouts', $layoutName);

        if (!$layoutConfig) {
            echo "<p>Layout not found.</p>";
            return;
        }

        // Create Navbar and Sidebar if specified
        $navbar  = null;
        $sidebar = null;

        if (!empty($layoutConfig['navbar'])) {
            $navbarConfig = JsonStorageService::fetch('navbars', $layoutConfig['navbar']);
            if ($navbarConfig) $navbar = new Navbar($navbarConfig);
        }

        if (!empty($layoutConfig['sidebar'])) {
            $sidebarConfig = JsonStorageService::fetch('sidebars', $layoutConfig['sidebar']);
            if ($sidebarConfig) $sidebar = new Sidebar($sidebarConfig);
        }

        // Build layout
        $layoutService = new LayoutService();
        $layout = $layoutService->createCustomLayout($navbar, $sidebar, $layoutConfig);

        // Render preview
        echo $layout->render([
            'view'     => 'developer_interface/layout_builder/gui_layout_preview',
            'viewData' => [],
        ]);
    }
}
