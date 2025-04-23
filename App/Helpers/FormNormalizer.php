<?php

declare(strict_types=1);

namespace App\Helpers;

class FormNormalizer
{
    public static function normalize(array $post): array
    {
        $cfg = [
            'formname'     => Sanitizer::flatten($post['formname'] ?? ''),
            'action'       => Sanitizer::flatten($post['action'] ?? ''),
            'method'       => Sanitizer::flatten($post['method'] ?? 'post'),
            'submitbutton' => Sanitizer::flatten($post['submitbutton'] ?? 'Submit'),
            'classes'      => trim(Sanitizer::flatten($post['classes'] ?? '')),
            'inputs'       => [],
            'selects'      => [],
            'textareas'    => [],
        ];

        $get = fn($arr, $i, $default = '') =>
            Sanitizer::flatten($arr[$i] ?? (is_array($arr[$i] ?? null) ? reset($arr[$i]) : $default));

        foreach (($post['input']['name'] ?? []) as $i => $nameArr) {
            $name = $get($post['input']['name'], $i);
            if ($name === '') continue;

            $type = $get($post['input']['type'], $i, 'text');
            $input = [
                'name'        => $name,
                'type'        => $type,
                'placeholder' => $get($post['input']['placeholder'], $i),
                'id'          => $get($post['input']['id'], $i),
                'value'       => $get($post['input']['value'], $i),
                'class'       => $get($post['input']['class'], $i),
                'validation'  => $get($post['input']['validation'], $i),
                'message'     => $get($post['input']['message'], $i),
            ];

            if (in_array($type, ['radio', 'checkbox'], true)) {
                $input['options'] = self::pairOptions(
                    $post['input']['options_label'][$i] ?? [],
                    $post['input']['options_value'][$i] ?? []
                );
            }

            $cfg['inputs'][] = $input;
        }

        foreach (($post['select']['name'] ?? []) as $i => $nameArr) {
            $name = $get($post['select']['name'], $i);
            if ($name === '') continue;

            $select = [
                'name'       => $name,
                'id'         => $get($post['select']['id'], $i),
                'classes'    => $get($post['select']['class'], $i),
                'validation' => $get($post['select']['validation'], $i),
                'message'    => $get($post['select']['message'], $i),
                'options'    => self::pairOptions(
                    $post['select']['options_label'][$i] ?? [],
                    $post['select']['options_value'][$i] ?? []
                ),
            ];

            $cfg['selects'][] = $select;
        }

        foreach (($post['textarea']['name'] ?? []) as $i => $nameArr) {
            $name = $get($post['textarea']['name'], $i);
            if ($name === '') continue;

            $cfg['textareas'][] = [
                'name'        => $name,
                'id'          => $get($post['textarea']['id'], $i),
                'placeholder' => $get($post['textarea']['placeholder'], $i),
                'class'       => $get($post['textarea']['class'], $i),
                'validation'  => $get($post['textarea']['validation'], $i),
                'message'     => $get($post['textarea']['message'], $i),
            ];
        }

        return $cfg;
    }

    private static function pairOptions($labels, $values): array
    {
        $paired = [];
        $flatLabels = self::flattenNested($labels);
        $flatValues = self::flattenNested($values);

        $count = max(count($flatLabels), count($flatValues));
        for ($i = 0; $i < $count; $i++) {
            $label = Sanitizer::flatten($flatLabels[$i] ?? '');
            $value = Sanitizer::flatten($flatValues[$i] ?? '');

            if ($label !== '' || $value !== '') {
                $paired[] = ['label' => $label, 'value' => $value];
            }
        }

        return $paired;
    }

    private static function flattenNested($input): array
    {
        $flat = [];
        $iterator = function ($value) use (&$flat, &$iterator) {
            if (is_array($value)) {
                foreach ($value as $v) $iterator($v);
            } else {
                $flat[] = $value;
            }
        };

        $iterator($input);
        return $flat;
    }
}
