<aside class="<?= $bodyClass ?? 'w-64 bg-gray-800 text-white h-full p-4' ?>">
    <?php if (!empty($items)): ?>
        <?php foreach ($items as $index => $item): ?>
            <?php if (!empty($item['html'])): ?>
                <?= $item['html'] ?>
                <?php unset($items[$index]); ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <ul class="space-y-2 mt-4">
        <?php foreach ($items as $item): ?>
            <?php
                $label = $item['label'] ?? '';
                $href  = $item['href'] ?? '#';
                $class = $item['class'] ?? 'block p-2 rounded hover:bg-gray-700 transition';
                $icon  = $item['icon'] ?? '';
                $attributes = '';

                if (!empty($item['attributes'])) {
                    foreach ($item['attributes'] as $key => $val) {
                        $attributes .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($val));
                    }
                }
            ?>
            <li>
                <a href="<?= htmlspecialchars($href) ?>" class="<?= htmlspecialchars($class) ?>" <?= $attributes ?>>
                    <span class="inline-block w-5"><?= $icon ?></span> <?= htmlspecialchars($label) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
