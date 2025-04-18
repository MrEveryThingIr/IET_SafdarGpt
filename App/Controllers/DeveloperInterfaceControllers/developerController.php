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

        $configFile = base_path("json_files/{$safeView}.json");
        if (!file_exists($configFile)) {
            die("❌ Config file not found: {$safeView}.json");
        }

        $json = json_decode(file_get_contents($configFile), true);
        if (!$json || !isset($json['functions'])) {
            die("❌ Invalid or missing 'functions' in config: {$safeView}.json");
        }

        $model = new FormJsonModel();
        $model->storeConfigArray($safeView, $json);

        echo $this->layout->render([
            'view' => 'developer_graphical_interface/' . $safeView,
            'viewData' => [
                'css' => $cssAttributes
            ]
        ]);
    }

    public function preview(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Method Not Allowed';
            return;
        }

        $formConfig = $this->normalizeFormConfig($_POST);
        render('templates/form_template', ['form_config' => $formConfig], 'layouts/main_layout');
    }

    private function normalizeFormConfig(array $post): array
    {
        $result = [
            'formname'     => $post['formname'] ?? '',
            'action'       => $post['action'] ?? '',
            'method'       => $post['method'] ?? 'post',
            'submitbutton' => $post['submitbutton'] ?? 'Submit',
            'classes'      => $post['classes'] ?? '',
            'inputs'       => [],
            'selects'      => [],
        ];

        $inputCount = count($post['name']);
        for ($i = 0; $i < $inputCount; $i++) {
            $result['inputs'][] = [
                'name'        => $post['name'][$i][0] ?? '',
                'placeholder' => $post['placeholder'][$i][0] ?? '',
                'id'          => $post['id'][$i][0] ?? '',
                'value'       => $post['value'][$i][0] ?? '',
                'class'       => $post['class'][$i][0] ?? '',
                'type'        => $post['type'][$i][0] ?? 'text',
            ];
        }

        $selectCount = count($post['select_name']);
        for ($i = 0; $i < $selectCount; $i++) {
            $select = [
                'name'    => $post['select_name'][$i][0] ?? '',
                'id'      => $post['select_id'][$i][0] ?? '',
                'classes' => $post['select_classes'][$i][0] ?? '',
                'options' => [],
            ];

            $optionLabels = $post['option_label'][$i] ?? [];
            $optionValues = $post['option_value'][$i] ?? [];

            foreach ($optionLabels as $j => $label) {
                $select['options'][] = [
                    'label' => $label ?? '',
                    'value' => $optionValues[$j] ?? '',
                ];
            }

            $result['selects'][] = $select;
        }

        return $result;
    }
}
