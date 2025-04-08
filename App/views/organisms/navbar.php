<?php
// App/views/organisms/navbar.php

function renderNavbarItems(array $items) {
    foreach ($items as $label => $value) {
        if (is_string($value)) {
            // Link
            echo '<li class="o-navbar__item">';
            echo '<a href="' . htmlspecialchars($value) . '" class="o-navbar__link">';
            echo htmlspecialchars($label);
            echo '</a>';
            echo '</li>';
        } elseif (is_array($value)) {
            // Submenu / dropdown
            echo '<li class="o-navbar__item o-navbar__item--has-submenu">';
            echo '<button class="o-navbar__toggle js-navbar-toggle">';
            echo htmlspecialchars($label);
            echo '</button>';

            // Nested items
            echo '<ul class="o-navbar__submenu js-navbar-submenu is-hidden">';
            renderNavbarItems($value);
            echo '</ul>';

            echo '</li>';
        }
    }
}
?>

<nav class="o-navbar js-navbar">
    <div class="o-navbar__brand">
        <?php echo htmlspecialchars($brand ?? 'MyApp'); ?>
    </div>
    <ul class="o-navbar__list">
        <?php
        if (!empty($items) && is_array($items)) {
            renderNavbarItems($items);
        } else {
            echo '<li class="o-navbar__item">No navbar items.</li>';
        }
        ?>
    </ul>
</nav>
