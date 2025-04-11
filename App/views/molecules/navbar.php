<?php
// App/views/organisms/navbar.php

function renderNavbarItems(array $items)
{
    foreach ($items as $label => $value) {
        if ($value === '__LOGOUT_FORM__') {
            echo '<li class="o-navbar__item">';
            echo '<form action="' . route('user.logout') . '" method="POST">';
            echo '<button type="submit" class="o-navbar__link px-3 py-2 text-red-600 hover:bg-red-100 rounded transition block">';
            echo htmlspecialchars($label);
            echo '</button>';
            echo '</form>';
            echo '</li>';
        } elseif (is_string($value)) {
            echo '<li class="o-navbar__item relative">';
            echo '<a href="' . htmlspecialchars($value) . '" class="o-navbar__link px-3 py-2 hover:bg-gray-100 rounded transition block">';
            echo htmlspecialchars($label);
            echo '</a>';
            echo '</li>';
        } elseif (is_array($value)) {
            // Dropdown
            echo '<li class="o-navbar__item o-navbar__item--has-submenu relative">';
            echo '<button class="o-navbar__toggle js-navbar-toggle px-3 py-2 rounded hover:bg-gray-100 inline-flex items-center transition">';
            echo htmlspecialchars($label);
            echo '<svg class="w-4 h-4 ml-1 transition-transform transform" fill="currentColor" viewBox="0 0 20 20">'
               . '<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.72'
               . 'a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0'
               . 'L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd" />'
               . '</svg>';
            echo '</button>';

            // Submenu
            echo '<ul class="o-navbar__submenu js-navbar-submenu absolute bg-white shadow-md border border-gray-200 rounded mt-1 w-40 hidden">';
            renderNavbarItems($value);
            echo '</ul>';
            echo '</li>';
        }
    }
}

?>

<nav class="o-navbar js-navbar w-full bg-white border-b border-gray-200 px-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between h-16">
        <!-- Brand -->
        <div class="o-navbar__brand font-bold text-xl">
            <?php echo htmlspecialchars($brand ?? 'MyApp'); ?>
        </div>
        <!-- Menu Items -->
        <ul class="o-navbar__list flex space-x-4 items-center">
            <?php
            if (!empty($items) && is_array($items)) {
                renderNavbarItems($items);
            } else {
                echo '<li class="o-navbar__item px-3 py-2">No navbar items</li>';
            }
            ?>
        </ul>
    </div>
</nav>
