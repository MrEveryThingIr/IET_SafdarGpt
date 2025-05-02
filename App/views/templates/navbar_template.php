<nav class="bg-white border-b border-gray-300 p-4 flex justify-between items-center shadow-sm">
    <div class="text-xl font-bold text-gray-800"><?= htmlspecialchars($brand ?? 'Brand') ?></div>
    <ul class="flex gap-4 items-center">
        <?php foreach ($items as $item): ?>
            <?php
                $label = $item['label'] ?? 'Link';
                $href = $item['href'] ?? '#';
                $class = $item['class'] ?? 'text-gray-700 hover:text-blue-600';
                $icon = $item['icon'] ?? ''; // e.g., <i class="fas fa-user"></i> or inline SVG
                $html = $item['html'] ?? null; // raw html if needed
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
</nav>
