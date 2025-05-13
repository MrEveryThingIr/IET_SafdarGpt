
<div class="max-w-5xl mx-auto p-8 bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg shadow-gray-200/50 space-y-8" dir="rtl">
 <!-- Search and Filter Section -->
 <div class="bg-white p-6 rounded-xl shadow-md">
    <form method="get" action="<?= route('ietannounce.all') ?>" class="space-y-4">
      <!-- Search Box -->
      <div>
        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">جستجو</label>
        <div class="relative">
          <input type="text" id="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" 
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                 placeholder="عنوان یا توضیحات...">
          <button type="submit" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>
        </div>
      </div>

      <div>
       
        <div>
          <label for="sd">عرضه</label>
          <input type="radio" name="sd" id="sd" value="supply" <?php echo (isset($_GET['sd'])&&($_GET['sd']=='supply'))?'checked':'' ?>>
        </div>

        <div>
          <label for="sd">تقاضا</label>
          <input type="radio" name="sd" id="sd" value="demand" <?php echo (isset($_GET['sd'])&&($_GET['sd']=='demand'))?'checked':'' ?> >
        </div>

        <div>
          <label for="sd">هردو</label>
          <input type="radio" name="sd" id="sd" value="" <?php echo ((!isset($_GET['sd']))||((isset($_GET['sd'])&&$_GET['sd']!='supply')&&($_GET['sd']!='demand')))?'checked':'' ?>>
        </div>
      </div>


      <div class="flex justify-end space-x-3 space-x-reverse">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          اعمال فیلتر
        </button>
        <a href="<?= route('ietannounce.all') ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
          حذف فیلترها
        </a>
      </div>
    </form>
  </div>
<h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500 pb-2 border-b border-gray-200">اعلانات سیستم</h2>

  <?php if (!empty($announces)): ?>
    <ul class="grid gap-6 md:grid-cols-3">
      <?php foreach ($announces as $announce): ?>
        <li class="bg-white p-6 rounded-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 shadow-sm hover:shadow-md">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($announce['title']) ?></h3>
              <span class="inline-block px-3 py-1 text-sm rounded-full <?= $announce['supply_demand'] === 'عرضه' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' ?>">
                <?= htmlspecialchars($announce['category']) ?> | <?= htmlspecialchars($announce['supply_demand']) ?>
              </span>
            </div>
            <div class="flex space-x-3 space-x-reverse">
              <a href="<?= route('ietannounce.show', ['id' => $announce['id']]) ?>" class="text-blue-600 hover:text-blue-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </a>
            </div>
          </div>
          <div class="mt-4 flex space-x-4 space-x-reverse">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
              </svg>
              نظرات
            </button>
            
     
          </div>
        </li>

        
        
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <div class="text-center py-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-700">اعلامی وجود ندارد</h3>
        <a href="<?php echo route('ietannounce.create') ?>" class="bg-yellow-100 rounded-sm">عرضه یا تقاضای خودرا اعلام نمایید</a>
    </div>
  <?php endif; ?>
</div>



