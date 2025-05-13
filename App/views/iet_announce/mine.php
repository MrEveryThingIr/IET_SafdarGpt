<?php 
// $announces = $data;
?>
<div class="max-w-5xl mx-auto p-6 space-y-6" dir="rtl">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">اعلام‌های من</h2>
    <a href="<?php echo route('ietannounce.create') ?>" class="px-4 py-2 bg-yellow-100 hover:bg-yellow-200 rounded-md font-medium text-blue-600 transition duration-150 ease-in-out transform hover:-translate-y-0.5">
      + عرضه یا تقاضای جدید
    </a>
  </div>

  <?php if (!empty($announces)): ?>
    <div class="grid gap-4">
      <?php foreach ($announces as $announce): ?>
        <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 border-blue-500">
          <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
            <div class="flex-1">
              <a href="<?php echo route('ietannounce.show',['id'=>$announce['id']])?>" class="block">
                <h3 class="text-xl font-bold text-gray-800 hover:text-blue-600 transition-colors duration-200">
                  <?= htmlspecialchars($announce['title']) ?>
                </h3>
              </a>
              
              <div class="flex flex-wrap gap-2 mt-2 mb-3">
                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                  <?= htmlspecialchars($announce['category']) ?>
                </span>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                  <?= htmlspecialchars($announce['supply_demand']) ?>
                </span>
                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                  <?= htmlspecialchars($announce['goods_services']) ?>
                </span>
              </div>
              
              <p class="text-gray-600 mt-2 leading-relaxed">
                <?= htmlspecialchars($announce['description']) ?>
              </p>
            </div>
            
            <div class="flex gap-3">
              <a href="<?= route('ietannounce.edit', ['id' => $announce['id']]) ?>" 
                 class="px-3 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md text-sm font-medium transition-colors duration-200 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                ویرایش
              </a>
              <form action="<?= route('ietannounce.delete', ['id' => $announce['id']]) ?>" method="POST" onsubmit="return confirm('آیا از حذف این آیتم مطمئن هستید؟');">
                <button type="submit" class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded-md text-sm font-medium transition-colors duration-200 flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  حذف
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="bg-white p-8 rounded-lg shadow-sm text-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <h3 class="mt-4 text-lg font-medium text-gray-700">هیچ اعلامی ثبت نشده است</h3>
      <p class="mt-1 text-gray-500">می‌توانید اولین اعلامیه خود را ایجاد کنید</p>
      <div class="mt-6">
        <a href="<?php echo route('ietannounce.create') ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors duration-200 inline-flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          ایجاد اعلام جدید
        </a>
      </div>
    </div>
  <?php endif; ?>
</div>