<!-- views/templates/sidebar_template.php -->
<aside class="w-64 bg-gray-800 text-white h-full p-4">
    <ul class="space-y-2">
        <?php foreach ($items as $item): ?>
            <?php
                $label = $item['label'] ?? 'Menu';
                $href  = $item['href']  ?? '#';
            ?>
            <li>
                <a href="<?= htmlspecialchars($href) ?>" class="block p-2 rounded hover:bg-gray-700">
                    <?= htmlspecialchars($label) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
