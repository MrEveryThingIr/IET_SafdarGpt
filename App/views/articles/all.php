<div class="container mx-auto px-4 py-8">
  <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">لیست مقالات</h1>
  
  <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <?php foreach ($articles as $article): ?>
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border border-gray-100">
      <!-- Article Header -->
      <div class="p-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
       <a href="<?php echo route('ietarticle.show_article',['id'=>$article['id']]) ?>"> <h2 class="text-xl font-bold text-gray-800 mb-2 text-right"><?= htmlspecialchars($article['title']) ?></h2></a>
        <div class="flex justify-between items-center">
          <span class="text-sm text-indigo-600 bg-indigo-50 px-2 py-1 rounded"><?= htmlspecialchars($article['field'] ?? 'بدون دسته') ?></span>
          <span class="text-xs text-gray-500"><?= date('Y/m/d', strtotime($article['created_at'])) ?></span>
        </div>
      </div>
      
      <!-- Article Stats -->
      <div class="p-5">
        <div class="flex justify-between mb-3">
          <div class="flex items-center">
            <svg class="w-4 h-4 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm text-gray-600">زمان مطالعه: <?= $article['time_to_read'] ?> دقیقه</span>
          </div>
          <span class="text-xs px-2 py-1 rounded-full 
            <?= $article['status'] === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
            <?= $article['status'] === 'published' ? 'منتشر شده' : 'پیش‌نویس' ?>
          </span>
        </div>
        
        <!-- Keywords -->
        <?php if ($article['key_words']): ?>
        <div class="mb-4">
          <h3 class="text-sm font-semibold text-gray-700 mb-1 text-right">کلمات کلیدی:</h3>
          <div class="flex flex-wrap gap-1 justify-end">
            <?php foreach (explode(',', $article['key_words']) as $keyword): ?>
            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded"><?= trim($keyword) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
        
        <!-- Language -->
        <div class="flex items-center justify-end">
          <span class="text-xs text-gray-500 mr-1">زبان: </span>
          <span class="text-xs font-medium 
            <?= $article['language_code'] === 'fa' ? 'text-red-600' : 'text-blue-600' ?>">
            <?= $article['language_code'] === 'fa' ? 'فارسی' : 'انگلیسی' ?>
          </span>
        </div>
      </div>
      
      <!-- Footer -->
      <div class="px-5 py-3 bg-gray-50 border-t flex justify-between items-center">
        <a href="/articles/<?= $article['slug'] ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
          مشاهده مقاله →
        </a>
        <span class="text-xs text-gray-500">ID: <?= $article['id'] ?></span>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

