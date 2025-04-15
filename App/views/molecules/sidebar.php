<?php
function renderSidebarItems(array $items)
{
    foreach ($items as $label => $value) {
        if (is_array($value) && isset($value['type']) && $value['type'] === 'profile') {
            echo '<div class="o-sidebar__profile text-center bg-gradient-to-b from-indigo-700 to-indigo-800 text-white p-4 rounded-lg mb-4 shadow">';
            echo '<img src="' . htmlspecialchars($value['image']) . '" class="w-20 h-20 rounded-full border-4 border-white shadow mb-2" alt="Profile">';
            echo '<div class="font-semibold">' . htmlspecialchars($value['name']) . '</div>';
            echo '<div class="text-xs text-indigo-200">ادمین</div>';
            echo '<div class="text-sm mt-2 text-emerald-300">موجودی: ' . htmlspecialchars($value['balance']) . '</div>';
            echo '</div>';
        } elseif (is_string($value)) {
            echo '<li class="o-sidebar__item"><a href="' . htmlspecialchars($value) . '" class="o-sidebar__link block px-4 py-2 text-sm text-indigo-100 hover:bg-indigo-600 rounded transition">' . htmlspecialchars($label) . '</a></li>';
        } elseif (is_array($value)) {
            echo '<li class="o-sidebar__item o-sidebar__item--has-submenu">';
            echo '<button class="o-sidebar__toggle js-sidebar-toggle w-full px-4 py-2 text-sm text-indigo-100 hover:bg-indigo-600 flex justify-between items-center rounded transition">';
            echo '<span>' . htmlspecialchars($label) . '</span>';
            echo '<svg class="w-4 h-4 ml-1 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.94l3.71-3.72a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>';
            echo '</button>';
            echo '<ul class="o-sidebar__submenu js-sidebar-submenu ml-4 mt-1 pl-2 border-l border-indigo-700 hidden">';
            renderSidebarItems($value);
            echo '</ul></li>';
        }
    }
}
?>
<aside class="o-sidebar js-sidebar bg-gradient-to-b from-gray-900 to-gray-800 text-white w-64 h-full hidden md:flex flex-col shadow-xl border-r border-gray-700">
    <div class="o-sidebar__inner flex-1 p-4 overflow-y-auto">
        <ul class="o-sidebar__list space-y-2">
            <?php echo !empty($items) ? renderSidebarItems($items) : '<li class="text-slate-400 px-4 py-2">No items found.</li>'; ?>
        </ul>
    </div>
</aside>
