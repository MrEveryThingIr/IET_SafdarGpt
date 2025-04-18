<?php

namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\Models\JsonModel\FormJsonModel;

class DocsController extends BaseController
{
    private Layout $layout;

    public function __construct()
    {
        // Navbar with branding and links
        $navbar = new Navbar([
            'brand' => 'Safdar.js Docs',
            'items' => [
                ['label' => 'Docs Home',     'href' => route('docs.index')],
                ['label' => 'Components',    'href' => route('docs.view', ['docName' => 'formBuilder'])]
            ]
        ]);

        // Sidebar with route helpers
        $sidebar = new Sidebar([
            'items' => [
                ['label' => 'Form Builder',     'href' => route('docs.view', ['docName' => 'formBuilder'])],
                ['label' => 'Dropdown',         'href' => route('docs.view', ['docName' => 'dropdown'])],
                ['label' => 'Sidebar',          'href' => route('docs.view', ['docName' => 'sidebar'])],
                ['label' => 'Tooltip',          'href' => route('docs.view', ['docName' => 'tooltip'])],
                ['label' => 'Modal',            'href' => route('docs.view', ['docName' => 'modal'])],
                ['label' => 'Fade+Dropdown',    'href' => route('docs.view', ['docName' => 'fadeDropdown'])],
                ['label' => 'Toggle+Modal',     'href' => route('docs.view', ['docName' => 'modalToggle'])]
            ]
        ]);

        // Layout includes orchestrator.js which handles live preview
        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'Safdar.js Documentation',
            'stylesPaths' => [],
            'scriptsPaths' => [
                'assets/js/safdar_lib/view/orchestrator.js'
            ],
            'layoutView' => 'layouts/main_layout'
        ]);
    }

    public function index(): void
    {
        echo $this->layout->render([
            'view' => 'developer_graphical_interface/developer_docs/index',
            'viewData' => [
                'message' => 'Select a component on the left to view documentation.'
            ]
        ]);
    }

    public function view(string $docName): void
    {
        $safeDoc = basename($docName); // security
        $model = new FormJsonModel();
        $json = $model->getConfigArray($safeDoc);
    
        if (empty($json)) {
            http_response_code(404);
            echo "❌ Doc not found or config missing: $safeDoc";
            return;
        }
    
        echo $this->layout->render([
            'view' => 'developer_graphical_interface/developer_docs/partials/doc_viewer',
            'viewData' => [
                'doc' => $json,
                'docName' => $safeDoc
            ]
        ]);
    }
    
}
