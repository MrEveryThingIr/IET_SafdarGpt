<?php  use function App\Helpers\escape_html_attr; ?>
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= escape_html_attr($post->title) ?></h1>

    <div class="mb-4 text-sm text-gray-600 flex justify-between">
        <span>📅 <?= date('F j, Y, g:i a', strtotime($post->created_at)) ?></span>
        <span>📁 <?= strtoupper($post->media_type) ?></span>
    </div>

    <?php

                   

 if ($post->media_type === 'image'): ?>
        <img src="<?= base_url("assets/uploads/image/{$post->media_path}") ?>" alt="Post Media"
             class="w-full max-h-[500px] object-contain rounded mb-4">
    <?php elseif ($post->media_type === 'video'): ?>
        <video controls class="w-full rounded mb-4">
            <source src="<?= base_url("assets/uploads/video/{$post->media_path}") ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <?php endif; ?>

    <div class="prose max-w-none text-gray-700 mb-4">
        <?= nl2br(escape_html_attr($post->content)) ?>
    </div>

    <?php if (!empty($post->keywords)): ?>
        <div class="mt-6">
            <h3 class="text-sm font-semibold text-gray-600 mb-1">🔖 Tags</h3>
            <div class="flex flex-wrap gap-2">
                <?php foreach (explode(',', $post->keywords) as $tag): ?>
                    <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">
                        #<?= trim($tag) ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
