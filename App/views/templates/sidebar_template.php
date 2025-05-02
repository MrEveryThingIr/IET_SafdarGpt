<aside class="w-64 bg-gray-800 text-white h-full p-4">
    <ul class="space-y-2">
        <?php foreach ($items as $item): ?>
            <?php
                $label = $item['label'] ?? 'Menu';
                $href = $item['href'] ?? '#';
                $class = $item['class'] ?? 'block p-2 rounded hover:bg-gray-700';
                $icon = $item['icon'] ?? '';
                $html = $item['html'] ?? null;
                $attributes = '';

                if (!empty($item['attributes'])) {
                    foreach ($item['attributes'] as $key => $val) {
                        $attributes .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($val));
                    }
                }
            ?>
            <li>
                <?php if ($html): ?>
                    <?= $html ?>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($href) ?>" class="<?= $class ?>" <?= $attributes ?>>
                        <?= $icon ?> <?= htmlspecialchars($label) ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
