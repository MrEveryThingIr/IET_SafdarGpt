<?php
namespace App\HTMLRenderer;

class Form implements RenderableInterface
{
    private array $config;

    public function __construct(array $config = [])
    {
        $defaults = [
            'method'       => 'POST',
            'action'       => '',
            'enctype'      => 'application/x-www-form-urlencoded',
            'form_id'      => 'form-' . uniqid(),
            'classes'      => 'space-y-4',
            'fields'       => [], // each field: ['type'=>'text', 'name'=>'username', 'label'=>'Username', ...]
            'stylesPaths'  => ['assets/css/atoms/forms.css'],
            'scriptsPaths' => ['assets/js/atoms/form-validation.js'],
        ];

        $this->config = array_merge($defaults, $config);
    }

    public function render(array $data = []): string
    {
        $templateData = array_merge($this->config, $data);

        ob_start();
        extract($templateData, EXTR_SKIP);
        include views_path('molecules/form.php');
        return ob_get_clean();
    }

    public function getStylesPaths(): array
    {
        return $this->config['stylesPaths'] ?? [];
    }

    public function getScriptsPaths(): array
    {
        return $this->config['scriptsPaths'] ?? [];
    }
}
