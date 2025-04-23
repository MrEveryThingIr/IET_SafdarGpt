<?php
function flattenValue($val) {
    if (is_array($val)) {
        return flattenValue(array_values($val)[0] ?? '');
    }
    return $val;
}


function escape($val): string {
    return htmlspecialchars(flattenValue($val), ENT_QUOTES, 'UTF-8');
}

function extractOptions(array $labelGroup, array $valueGroup): array {
    $options = [];
    $count = max(count($labelGroup), count($valueGroup));

    for ($i = 0; $i < $count; $i++) {
        $label = flattenValue($labelGroup[$i] ?? '');
        $value = flattenValue($valueGroup[$i] ?? '');
        if ($label !== '' || $value !== '') {
            $options[] = ['label' => $label, 'value' => $value];
        }
    }

    return $options;
}

function normalizeFormSection(array $section): array {
    $normalized = [];
    $count = count($section['name'] ?? []);

    for ($i = 0; $i < $count; $i++) {
        $name = flattenValue($section['name'][$i] ?? '');
        if ($name === '') continue;

        $normalized[] = array_map(
            fn($field) => flattenValue($field[$i] ?? ''),
            $section
        );
    }

    return $normalized;
}

function deepFlattenArray(array $arr): array {
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $arr[$key] = deepFlattenArray($val);
        } else {
            $arr[$key] = trim((string)$val);
        }
    }
    return $arr;
}