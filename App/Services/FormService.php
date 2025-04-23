<?php
declare(strict_types=1);

namespace App\Services;

use App\Helpers\Sanitizer;
use App\Models\FormSubmissionModel;

class FormService
{
    private FormConfigService   $cfgService;
    private FormSubmissionModel $submissions;

    public function __construct()
    {
        $this->cfgService = new FormConfigService();
        $this->submissions = new FormSubmissionModel();
    }

    /** Retrieve a form’s JSON config. */
    public function getConfig(string $formName): array
    {
        return $this->cfgService->getConfig($formName);
    }

    /**
     * Validate a set of POSTed values against the config’s “validation” keys.
     *
     * @return array<string,string[]>  field→errors
     */
    public function validate(array $config, array $input): array
    {
        $errors = [];

        foreach (['inputs','selects','textareas'] as $section) {
            foreach ($config[$section] ?? [] as $fieldCfg) {
                $name       = $fieldCfg['name'];
                $rules      = (string)($fieldCfg['validation'] ?? '');
                $value      = Sanitizer::flatten($input[$name] ?? '');
                if (str_contains($rules, 'required') && $value === '') {
                    $errors[$name][] = "{$name} is required.";
                }
                // Extend here with email, min, max, pattern, etc.
            }
        }

        return $errors;
    }

    /**
     * Persist a valid submission, returning its new ID.
     */
    public function submit(string $formName, array $input): int
    {
        return $this->submissions->create($formName, $input);
    }

    /** Fetch all submissions for a form. */
    public function listSubmissions(string $formName): array
    {
        return $this->submissions->findByForm($formName);
    }
}
