<?php

namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;
use App\FileServices\JsonStorageService;
use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\HTMLServices\LayoutService;

class LayoutBuilderController extends BaseController
{
    private $layout;
    private $layoutService;
    public function __construct(){
        // $this->layout=new Layout();
        $this->layoutService=new LayoutService();
    }
    public function create()
    {
        $layout=$this->layoutService->createDeveloperLayout();

        $html=$layout->render(
            ['view'=>'developer_interface\layout_builder\gui_layout_create','viewData'=>['example_of_data'=>'select your favorite layout or create new','the_list_of_existing_layouts'=>['layout1,layot2']]]
        );
        echo $html;
    }

    public function store()
    {
        $layoutName = $_POST['layout_name'] ?? null;
        $containers = $_POST['containers'] ?? [];
        $navbar     = $_POST['navbar'] ?? null;
        $sidebar    = $_POST['sidebar'] ?? null;
        $styles     = array_map('trim', explode(',', $_POST['stylesPaths'] ?? ''));
        $scripts    = array_map('trim', explode(',', $_POST['scriptsPaths'] ?? ''));

        if (!$layoutName) {
            $_SESSION['errors'] = ['Layout name is required'];
            return $this->redirect(route('gui.layout.create'));
        }

        $config = [
            'name'         => $layoutName,
            'containers'   => $containers,
            'navbar'       => $navbar,
            'sidebar'      => $sidebar,
            'stylesPaths'  => $styles,
            'scriptsPaths' => $scripts,
        ];

        $success = JsonStorageService::store('layouts', $layoutName, $config);

        if ($success) {
            $_SESSION['success'] = "Layout '{$layoutName}' saved!";
            return $this->redirect(route('gui.preview') . "?layout={$layoutName}");
        } else {
            $_SESSION['errors'] = ["Failed to save layout."];
            return $this->redirect(route('gui.layout.create'));
        }
    }
}
