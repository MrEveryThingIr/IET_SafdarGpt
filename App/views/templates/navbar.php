<?php

function renderNavbarItems(array $items)
{
    foreach ($items as $label => $value) {
        if ($value === '__LOGOUT_FORM__') {
            echo '<li class="o-navbar__item">';
            echo '<form action="' . route('user.logout') . '" method="POST">';
            echo '<button type="submit" class="o-navbar__link px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 ease-in-out font-medium hover:text-red-700 hover:shadow-sm block">' . htmlspecialchars($label) . '</button>';
            echo '</form>';
            echo '</li>';
        } elseif (is_string($value)) {
            echo '<li class="o-navbar__item relative group">';
            echo '<a href="' . htmlspecialchars($value) . '" class="o-navbar__link px-4 py-2 hover:bg-gray-50 rounded-lg transition-all duration-200 ease-in-out font-medium text-gray-700 hover:text-blue-600 block">' . htmlspecialchars($label) . '</a>';
            echo '<div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 h-0.5 bg-blue-600 w-0 group-hover:w-4/5 transition-all duration-300 ease-out"></div>';
            echo '</li>';
        } elseif (is_array($value)) {
            echo '<li class="o-navbar__item o-navbar__item--has-submenu relative group">';
            echo '<button class="o-navbar__toggle js-navbar-toggle px-4 py-2 rounded-lg hover:bg-gray-50 inline-flex items-center transition-all duration-200 ease-in-out font-medium text-gray-700 hover:text-blue-600">';
            echo htmlspecialchars($label);
            echo '<svg class="w-4 h-4 ml-1 transform transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.72a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>';
            echo '</button>';
            echo '<ul class="o-navbar__submenu js-navbar-submenu hidden absolute bg-white border border-gray-200 shadow-lg rounded-lg mt-1 py-1 min-w-[180px] z-50 group-hover:block hover:block">';
            renderNavbarItems($value);
            echo '</ul>';
            echo '</li>';
        }
    }
}
?>
<nav class="o-navbar js-navbar w-full bg-white border-b border-gray-100 px-6 shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto flex justify-between h-16 items-center">
        <div class="o-navbar__brand font-bold text-2xl text-blue-600"><?= htmlspecialchars($brand ?? 'IET Developer') ?></div>
        <ul class="o-navbar__list flex space-x-2 items-center">
            <?php echo !empty($items) ? renderNavbarItems($items) : '<li class="o-navbar__item px-4 py-2 text-gray-400">No navbar items</li>'; ?>
        </ul>
    </div>
</nav>