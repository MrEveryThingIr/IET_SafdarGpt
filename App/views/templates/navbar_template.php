
<!-- views/templates/navbar_template.php -->
<nav class="bg-white border-b border-gray-300 p-4 flex justify-between items-center shadow-sm">
    <div class="text-xl font-bold text-gray-800"><?= htmlspecialchars($brand ?? 'Brand') ?></div>
    <ul class="flex gap-4">
        <?php foreach ($items as $item): ?>
            <?php
                $label = $item['label'] ?? 'Link';
                $href  = $item['href']  ?? '#';
            ?>
            <li>
                <a href="<?= htmlspecialchars($href) ?>" class="text-gray-700 hover:text-blue-600">
                    <?= htmlspecialchars($label) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
