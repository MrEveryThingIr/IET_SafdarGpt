<?php

function sidebar_add_item(
    array $sidebar,
    string $label,
    ?int $index = null,
    string $href = '#',
    string $class = '',
    string $icon = '',
    bool $active = false,
    array $attributes = []
): array {
    if (!isset($sidebar['items']) || !is_array($sidebar['items'])) {
        $sidebar['items'] = [];
    }

    $item = [
        'label' => $label,
        'href'  => $href,
        'class' => trim('block p-2 rounded hover:bg-gray-700 transition cursor-pointer ' . $class),
        'icon'  => $icon,
        'attributes' => $attributes,
    ];

    if ($active) {
        $item['class'] .= ' bg-gray-700';
    }

    if ($index !== null) {
        $sidebar['items'][$index] = $item;
    } else {
        $sidebar['items'][] = $item;
    }

    return $sidebar;
}

function sidebar_add_header(
    array $sidebar,
    array $user,
    string $balance = '0',
    string $bio = '',
    string $class = ''
): array {
    $class = trim($class ?: 'mb-4 p-4 bg-gray-900 rounded');
    $fullName = trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''));
    $html = '
        <div class="' . htmlspecialchars($class) . '">
            <div class="flex items-center space-x-3">
                <img src="' . htmlspecialchars($user['img']) . '" class="w-12 h-12 rounded-full object-cover" alt="' . htmlspecialchars($fullName) . '">
                <div>
                    <div class="font-semibold">' . htmlspecialchars($fullName) . '</div>
                    <div class="text-sm text-gray-400">💰 ' . htmlspecialchars($balance) . '</div>
                </div>
            </div>
            <p class="text-xs mt-2 text-gray-500">' . $bio . '</p>
        </div>
    ';

    if (!isset($sidebar['items']) || !is_array($sidebar['items'])) {
        $sidebar['items'] = [];
    }

    array_unshift($sidebar['items'], ['html' => $html]);

    return $sidebar;
}

function sidebar_set_style(array $sidebar, string $bgColor = 'bg-gray-800 text-white p-4'): array {
    $sidebar['bodyClass'] = trim($bgColor);
    return $sidebar;
}
