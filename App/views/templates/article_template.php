<article class="prose max-w-3xl mx-auto py-8 px-4">
    <header>
        <h1 class="text-3xl font-bold mb-2"><?= htmlspecialchars($title) ?></h1>
        <p class="text-gray-500 text-sm mb-4">
            Published: <?= htmlspecialchars(date('F j, Y', strtotime($created_at))) ?>
            <?php if (!empty($time_to_read)): ?>
                • <?= (int)$time_to_read ?> min read
            <?php endif; ?>
        </p>
        <?php if (!empty($field)): ?>
            <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded">
                <?= htmlspecialchars($field) ?>
            </span>
        <?php endif; ?>
    </header>

    <section class="mt-6 space-y-6">
        <?php foreach ($blocks as $block): ?>
            <div class="<?= htmlspecialchars($block['css_class'] ?? '') ?>">
                <?= $blockRenderer->renderBlock($block) ?>
            </div>
        <?php endforeach; ?>
    </section>
</article>
