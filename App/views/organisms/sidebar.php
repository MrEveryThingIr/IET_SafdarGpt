<?php
// App/views/organisms/sidebar.php

/**
 * Renders a nested sidebar from $items.
 * We'll combine BEM naming ("o-sidebar__") with Tailwind classes for layout & styling.
 * Also use .js- classes for JS hooks.
 */
function renderSidebarItems(array $items) {
    foreach ($items as $label => $value) {
        if (is_string($value)) {
            // Single link
            echo '<li class="o-sidebar__item">';
            echo '<a href="' . htmlspecialchars($value) . '" class="o-sidebar__link block px-3 py-2 hover:bg-gray-700 rounded transition">';
            echo htmlspecialchars($label);
            echo '</a>';
            echo '</li>';
        } elseif (is_array($value)) {
            // Nested submenu
            echo '<li class="o-sidebar__item o-sidebar__item--has-submenu">';
            echo '<button class="o-sidebar__toggle js-sidebar-toggle w-full text-left px-3 py-2 rounded hover:bg-gray-700 inline-flex items-center justify-between transition">';
            echo '<span>' . htmlspecialchars($label) . '</span>';
            // Down arrow icon
            echo '<svg class="w-4 h-4 ml-2 transition-transform transform" fill="currentColor" viewBox="0 0 20 20">';
            echo '<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.72'
               . 'a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0'
               . 'L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd" />';
            echo '</svg>';
            echo '</button>';

            // The submenu (hidden by default)
            echo '<ul class="o-sidebar__submenu js-sidebar-submenu ml-4 border-l border-gray-600 pl-2 hidden">';
            // Recursively render nested items
            renderSidebarItems($value);
            echo '</ul>';

            echo '</li>';
        }
    }
}
?>

<aside class="o-sidebar js-sidebar bg-gray-800 text-white h-full w-64 hidden md:flex flex-col">
    <div class="o-sidebar__inner flex-1 p-3 overflow-y-auto">
        <ul class="o-sidebar__list space-y-1">
            <?php
            if (!empty($items) && is_array($items)) {
                renderSidebarItems($items);
            } else {
                echo '<li class="o-sidebar__item px-3 py-2">No sidebar items</li>';
            }
            ?>
        </ul>
    </div>
</aside>
