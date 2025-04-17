<?php
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\Models\JsonModel\FormJsonModel;

class DeveloperController extends BaseController
{
    private array $layoutConfig = [
        'title' => 'create_form',
        'stylesPaths' => [],
        'scriptsPaths' => [
            "assets/js/safdar_lib/view/formBuilder.js"
        ],
        'layoutView' => 'layouts/main_layout',
    ];

    public Layout $layout;

    public function __construct()
    {
        $navbar = new Navbar([
            'brand' => 'IET System',
            'items' => [
                ['label' => 'Home', 'href' => '/home'],
                ['label' => 'Docs', 'href' => '/docs'],
            ]
        ]);

        $sidebar = new Sidebar([
            'items' => [
                ['label' => 'Dashboard', 'href' => '/developer/index'],
                ['label' => 'Create Form', 'href' => '/developer/create_form'],
            ]
        ]);

        $this->layout = new Layout($navbar, $sidebar, $this->layoutConfig);
    }

    public function view(string $view_name): void
    {
        $cssAttributes = include __DIR__ . '/../../HTMLRenderer/cssAttributes.php';
        $safeView = basename($view_name);

        $config = [
            'functions' => [
                [
                    'key' => 'cloneElement',
                    'args' => [
                        'triggerSelector' => '.add_input',
                        'targetSelector' => '.input',
                        'eventType' => 'click',
                        'appendToSelector' => '#input-container'
                    ]
                ],
                [
                    'key' => 'cloneElement',
                    'args' => [
                        'triggerSelector' => '.add_selectoption',
                        'targetSelector' => '.selectoption',
                        'eventType' => 'click',
                        'appendToSelector' => '#select-container'
                    ]
                ],
                [
                    'key' => 'delegateEvent',
                    'args' => [
                        'parentSelector' => '#select-container',
                        'triggerSelector' => '.addoption',
                        'targetSelector' => '.option',
                        'eventType' => 'click',
                        'appendToSelector' => 'closest:.selectoption'
                    ]
                ]
            ]
        ];

        $model = new FormJsonModel();
        $saveSuccess = $model->storeConfigArray($safeView, $config);

        if (!$saveSuccess) {
            die("❌ Failed to save config for view: $safeView");
        }

        $html = $this->layout->render([
            'view' => 'developer_graphical_interface/' . $safeView,
            'viewData' => [
                'css' => $cssAttributes
            ]
        ]);

        echo $html;
    }


    public function preview(): void
    {
        
        $form_config = $_POST;
        var_dump($form_config);
       
    //     // Basic validation (optional)
    //     if (!is_array($form_config)) {
    //         http_response_code(400);
    //         echo 'Invalid form data.';
    //         return;
    //     }

    //     // Direct render without layout system
    //     render(
    //         'templates/form_template',
    //         ['form_config' => $form_config],
    //         'layouts/main_layout' // still using the layout
    //     );
    }
}
