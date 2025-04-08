<?php
// App/views/organisms/sidebar.php

/**
 * Renders a nested sidebar from the $items array.
 * We'll adopt a BEM-like naming: .o-sidebar for "organism-sidebar", 
 * .o-sidebar__item, .o-sidebar__submenu, etc.
 * Also use .js- prefixed classes for JS hooks (toggle, submenu).
 */

// Recursive function to render nested items
function renderSidebarItems(array $items, int $level = 0) {
    foreach ($items as $label => $value) {
        if (is_string($value)) {
            // It's a link
            echo '<li class="o-sidebar__item">';
            echo '<a href="' . htmlspecialchars($value) . '" class="o-sidebar__link">';
            echo htmlspecialchars($label);
            echo '</a>';
            echo '</li>';
        } elseif (is_array($value)) {
            // It's a nested submenu
            echo '<li class="o-sidebar__item o-sidebar__item--has-submenu">';
            
            // Toggle button:
            // We'll place a .js-sidebar-toggle class for JS to attach 
            echo '<button class="o-sidebar__toggle js-sidebar-toggle">';
            echo htmlspecialchars($label);
            echo '</button>';

            // Submenu
            // .is-hidden or .o-sidebar__submenu--hidden can hide it by default
            echo '<ul class="o-sidebar__submenu js-sidebar-submenu is-hidden">';
            // Recursively call ourselves
            renderSidebarItems($value, $level + 1);
            echo '</ul>';

            echo '</li>';
        }
    }
}
?>

<aside class="o-sidebar js-sidebar">
    <ul class="o-sidebar__list">
        <?php
        if (!empty($items) && is_array($items)) {
            renderSidebarItems($items);
        } else {
            echo '<li class="o-sidebar__item">No sidebar items.</li>';
        }
        ?>
    </ul>
</aside>
