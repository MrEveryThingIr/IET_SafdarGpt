<?php

namespace App\HTMLServices;

use App\HTMLRenderer\Form;

class FormService
{
    public function createDefaultForm(array $overrides = []): Form
    {
        $defaultFields = [
            [
                'type' => 'text',
                'name' => 'username',
                'label' => 'Username',
                'placeholder' => 'Enter your username',
                'required' => true
            ],
            [
                'type' => 'email',
                'name' => 'email',
                'label' => 'Email',
                'placeholder' => 'Enter your email',
                'required' => true
            ],
            [
                'type' => 'password',
                'name' => 'password',
                'label' => 'Password',
                'placeholder' => 'Enter your password',
                'required' => true
            ]
        ];

        $config = array_merge([
            'action' => '#',
            'method' => 'POST',
            'fields' => $defaultFields
        ], $overrides);

        return new Form($config);
    }

    public function listAvailable(): array
    {
        return list_json_components('forms');
    }
}
