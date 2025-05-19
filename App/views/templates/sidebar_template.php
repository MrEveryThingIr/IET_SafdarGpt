<aside class="<?= $bodyClass ?? 'w-72 bg-indigo-300 text-white flex flex-col max-h-screen overflow-y-auto' ?>">
    <div class="p-4">
        <?php
            // Separate HTML-based items and link-based items
            $htmlItems = array_filter($items, fn($item) => !empty($item['html']));
            $linkItems = array_filter($items, fn($item) => empty($item['html']));
        ?>

        <?php foreach ($htmlItems as $item): ?>
            <?= $item['html'] ?>
        <?php endforeach; ?>
    </div>

    <div class="flex-1 overflow-y-auto">
        <ul class="space-y-2 px-4 pb-4">
            <?php foreach ($linkItems as $item): ?>
                <?php
                    $label = $item['label'] ?? '';
                    $href  = $item['href'] ?? '#';
                    $class = 'block p-2 rounded hover:bg-gray-700 transition ' . ($item['class'] ?? '');
                    $icon  = $item['icon'] ?? '';
                    $attributes = '';

                    if (!empty($item['attributes'])) {
                        foreach ($item['attributes'] as $key => $val) {
                            $attributes .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($val));
                        }
                    }
                ?>
                <li>
                    <a href="<?= htmlspecialchars($href) ?>" class="<?= htmlspecialchars(trim($class)) ?>"<?= $attributes ?>>
                        <span class="inline-block w-5"><?= $icon ?></span> <?= htmlspecialchars($label) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>
