<?php

namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;
use App\HTMLServices\NavbarService;
use App\HTMLServices\SidebarService;
use App\HTMLRenderer\Layout;

class LayoutBuilderController extends BaseController
{
    public function create()
    {
        $navbarService = new NavbarService();
        $sidebarService = new SidebarService();

        $navbars = $navbarService->listAvailable(); // You define this to fetch from DB or predefined list
        $sidebars = $sidebarService->listAvailable();

        $this->render('developer_interface/layout_builder/gui_layout_create', [
            'navbars'  => $navbars,
            'sidebars' => $sidebars,
        ]);
    }

    public function store()
    {
        $data = $_POST;

        $layoutConfig = [
            'title'        => $data['title'],
            'layoutView'   => $data['layout_view'],
            'stylesPaths'  => explode(',', $data['styles']),
            'scriptsPaths' => explode(',', $data['scripts']),
        ];

        $_SESSION['created_layout_config'] = $layoutConfig;

        redirect(route('gui.layout.preview'));
    }

    public function preview()
    {
        $config = $_SESSION['created_layout_config'] ?? [];

        // For now just render layout directly with placeholder content
        $layout = new Layout(null, null, $config);

        echo $layout->render([
            'view' => 'developer_interface/layout_builder/gui_layout_preview',
            'viewData' => ['note' => 'This is a layout preview area.']
        ]);
    }
}
