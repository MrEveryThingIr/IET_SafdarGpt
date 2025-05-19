<article class="max-w-3xl border-gray-900 mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <header class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3 leading-tight">
            <?= htmlspecialchars($title) ?>
        </h1>
        
        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mb-4">
            <span>
                Published: <?= htmlspecialchars(date('F j, Y', strtotime($created_at))) ?>
            </span>
            
            <?php if (!empty($time_to_read)): ?>
                <span class="text-gray-300">•</span>
                <span><?= (int)$time_to_read ?> min read</span>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($field)): ?>
            <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wide text-blue-800 bg-blue-100 rounded-full">
                <?= htmlspecialchars($field) ?>
            </span>
        <?php endif; ?>
    </header>

    <section class="prose prose-lg max-w-none">
        <?php foreach ($blocks as $block): ?>
            <div class="<?= htmlspecialchars($block['css_class'] ?? '') ?>">
                <?= $blockRenderer->renderBlock($block) ?>
            </div>
        <?php endforeach; ?>
    </section>
</article>