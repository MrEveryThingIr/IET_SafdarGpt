<!-- Flash Messages -->
<div class="space-y-2">
    <?php isset($_SESSION['error']) ? errorMessage() : '' ?>
    <?php isset($_SESSION['success']) ? errorMessage() : '' ?>
</div>

<?php
$blockTypes = ['paragraph','heading','image','audio','video','list','quote','divider','embed','cta','faq','section'];
require views_path('articles/modal.php');
require views_path('articles/modal_edit.php');
require views_path('articles/display_article_blocks.php');
?>

<!-- Article Body -->
<article class="prose max-w-4xl mx-auto bg-white rounded shadow p-6 mb-8">
    <header class="mb-6">
        <h1 class="text-4xl font-bold mb-2 text-gray-900"><?= htmlspecialchars($article['title']) ?></h1>
        <div class="text-sm text-gray-500 flex items-center justify-between">
            <span>✍️ نوشته‌شده توسط: <?= htmlspecialchars(user($article['author_id'])['username']) ?></span>
            <span>📅 <?= htmlspecialchars(date('Y/m/d', strtotime($article['created_at']))) ?></span>
        </div>
    </header>

    <div class="border-t border-gray-200 pt-6">
     
        <!-- Render Structured Sections -->
        <?php foreach ($sections as $section): ?>
            <?php if (isset($section['heading'])): ?>
                <?= render_article_block($section['heading']) ?>
            <?php endif; ?>

            <?php if (!empty($section['content'])): ?>
                <?php foreach ($section['content'] as $block): ?>
                    <?= render_article_block($block) ?>
                <?php endforeach; ?>
            <?php elseif (isset($section['single_block'])): ?>
                <?= render_article_block($section['single_block']) ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</article>

<!-- All Add Modals -->
<div class="target_modal">
    <?php foreach ($blockTypes as $blockType): ?>
        <?php $modalId = 'add' . ucfirst($blockType) . 'Modal'; ?>
        <div id="<?= $modalId ?>" class="modal hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
            <?= render_modal_by_type($blockType, $article['id']) ?>
        </div>
    <?php endforeach; ?>
</div>