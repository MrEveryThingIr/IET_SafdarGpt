<div class="container mx-auto px-4 py-8">
    <!-- Header and Create Button -->
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">لیست مقالات  </h2>
    <a href="<?php echo route('ietarticles.create') ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-150 ease-in-out transform hover:-translate-y-0.5 flex items-center gap-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
ایجاد مقاله جدید    </a>
  </div>
<?php $articles=$data['my_articles'] ?>
  <?php if(!empty($articles)): ?>
  <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <?php
     foreach ($articles as $article): 
    $subcategory_name = $article['main_sub_cate_name'] ?? '---';    
        ?>
        
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border border-gray-100">
      <!-- Article Header -->
      <div class="p-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
       <h2 class="text-xl font-bold text-gray-800 mb-2 text-right"><?= htmlspecialchars($article['title']) ?></h2>
        <div class="flex justify-between items-center">
          <span class="text-sm text-indigo-600 bg-indigo-50 px-2 py-1 rounded"><?= htmlspecialchars($subcategory_name ?? 'بدون دسته') ?></span>
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
    
        <a  href="<?php echo route('ietarticles.show_article',['id'=>$article['id']]) ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
          مشاهده مقاله →
        </a>
        <span class="text-xs text-gray-500">ID: <?= $article['id'] ?></span>
      </div>
    </div>
    <?php endforeach; ?>

        <?php else: ?>

        <div class="p-8 bg-white border text-center">
        <p class="text-gray-500">No categories found. Create your first one!</p>
      </div>
    
    <?php endif; ?>
  </div>
</div>

