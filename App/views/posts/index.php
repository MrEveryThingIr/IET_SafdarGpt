<?php use function App\Helpers\escape_html_attr; ?>

<div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">🗂 All Posts</h1>



    <?php if (!empty($posts)): ?>
        <div class="space-y-6">
            <?php foreach ($posts as $post):  ?>
            <a href="<?= route('ietpost.single', ['id' => $post['id']]) ?>" 
                   class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <h2 class="text-xl font-semibold text-blue-700">
                        <?= escape_html_attr($post['title']) ?>
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        <?= substr(strip_tags($post['content']), 0, 100) ?>...
                    </p>
                    <div class="flex justify-between items-center text-sm text-gray-500 mt-2">
                        <span>📁 <?= strtoupper($post['media_type']) ?></span>
                        <span>📅 <?= date('Y-m-d H:i', strtotime($post['created_at'])) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <?php if (!empty($_SESSION['error'])): ?>
        <div class="mb-6 p-4 rounded bg-red-100 text-red-700 border border-red-200 text-center">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
