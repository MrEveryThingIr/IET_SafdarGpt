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
            'assets/js/safdar_lib/view/orchestrator.js'
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
                  'appendToSelector' => '#input-container',
                  'eventType' => 'click',
                  'contextKey' => 'input' // optional
                ]
              ],
              [
                'key' => 'cloneElement',
                'args' => [
                  'triggerSelector' => '.add_selectoption',
                  'targetSelector' => '.selectoption',
                  'appendToSelector' => '#select-container',
                  'eventType' => 'click',
                  'contextKey' => 'selectoption'
                ]
              ],
              [
                'key' => 'delegateEvent',
                'args' => [
                  'parentSelector' => '#select-container',
                  'triggerSelector' => '.addoption',
                  'targetSelector' => '.option',
                  'eventType' => 'click',
                  'appendToSelector' => 'closest:.selectoption',
                  'contextKey' => 'selectoption'
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
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo 'Method Not Allowed';
        return;
    }

    $formConfig = $_POST;

    // Process and normalize dynamic fields
    $formConfig = $this->normalizeFormConfig($formConfig);

    // Render using the template view
    render('templates/form_template', ['form_config' => $formConfig], 'layouts/main_layout');
}

/**
 * Normalize form config with nested inputs/selects
 */
private function normalizeFormConfig(array $post): array
{
    $result = [
        'formname'      => $post['formname'] ?? '',
        'action'        => $post['action'] ?? '',
        'method'        => $post['method'] ?? 'post',
        'submitbutton'  => $post['submitbutton'] ?? 'Submit',
        'classes'       => $post['classes'] ?? '',
        'inputs'        => [],
        'selects'       => [],
    ];

    // Parse inputs
    $names = $post['name'] ?? [];
    foreach ($names as $i => $name) {
        if (empty($name)) continue;

        $result['inputs'][] = [
            'name'        => $name,
            'placeholder' => $post['placeholder'][$i] ?? '',
            'id'          => $post['id'][$i] ?? '',
            'value'       => $post['value'][$i] ?? '',
            'class'       => $post['class'][$i] ?? '',
            'type'        => $post['type'][$i] ?? 'text',
        ];
    }

    // Parse selects and their options
    $selectNames = $post['select_name'] ?? [];
    foreach ($selectNames as $i => $selectName) {
        if (empty($selectName)) continue;

        $select = [
            'name'    => $selectName,
            'id'      => $post['select_id'][$i] ?? '',
            'classes' => $post['select_classes'][$i] ?? '',
            'options' => [],
        ];

        // Get corresponding options (assumes flat index alignment, refine as needed)
        $optionLabels = $post['option_label'] ?? [];
        $optionValues = $post['option_value'] ?? [];

        for ($j = 0; $j < count($optionLabels); $j++) {
            if (!empty($optionLabels[$j]) || !empty($optionValues[$j])) {
                $select['options'][] = [
                    'label' => $optionLabels[$j],
                    'value' => $optionValues[$j],
                ];
            }
        }

        $result['selects'][] = $select;
    }

    return $result;
}

}
