<?php
function renderSidebarItems(array $items) {
    foreach ($items as $label => $value) {
        if (is_array($value) && isset($value['type']) && $value['type'] === 'profile') {
            echo '<div class="o-sidebar__profile flex flex-col items-center text-center bg-gradient-to-b from-indigo-600 to-indigo-700 text-white rounded-xl p-3 mb-4 shadow-md">';
            echo '<img src="' . htmlspecialchars($value['image']) . '" alt="Avatar" class="w-14 h-14 rounded-full border-2 border-white shadow-md mb-2">';
            echo '<div class="font-semibold text-sm leading-tight">' . htmlspecialchars($value['name']) . '</div>';
            echo '<div class="text-xs text-indigo-100 mt-1">ادمین</div>';
            echo '<div class="text-xs text-emerald-200 mt-2">موجودی: ' . htmlspecialchars($value['balance']) . '</div>';
            echo '</div>';
        } elseif (is_string($value)) {
            echo '<li class="o-sidebar__item">';
            echo '<a href="' . htmlspecialchars($value) . '" class="o-sidebar__link block px-4 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-600 hover:text-white transition">';
            echo htmlspecialchars($label);
            echo '</a>';
            echo '</li>';
        } elseif (is_array($value)) {
            echo '<li class="o-sidebar__item o-sidebar__item--has-submenu">';
            echo '<button class="o-sidebar__toggle js-sidebar-toggle w-full px-4 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-600 flex items-center justify-between transition">';
            echo '<span>' . htmlspecialchars($label) . '</span>';
            echo '<svg class="w-4 h-4 ml-1 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">';
            echo '<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.72a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd" />';
            echo '</svg>';
            echo '</button>';
            echo '<ul class="o-sidebar__submenu js-sidebar-submenu ml-4 mt-1 pl-2 border-l border-indigo-700 hidden space-y-1">';
            renderSidebarItems($value);
            echo '</ul>';
            echo '</li>';
        }
    }
}
?>

<aside class="o-sidebar js-sidebar bg-gradient-to-b from-slate-900 to-slate-800 text-white w-64 h-full hidden md:flex flex-col shadow-2xl border-r border-slate-700">
    <div class="o-sidebar__inner flex-1 p-3 overflow-y-auto">
        <ul class="o-sidebar__list space-y-2">
            <?php
            if (!empty($items)) {
                renderSidebarItems($items);
            } else {
                echo '<li class="o-sidebar__item text-sm text-slate-400 px-4 py-2">No items found.</li>';
            }
            ?>
        </ul>
    </div>
</aside>
