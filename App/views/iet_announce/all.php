<div class="max-w-5xl mx-auto p-8 bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg shadow-gray-200/50 space-y-8" dir="rtl">
  <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500 pb-2 border-b border-gray-200">اعلانات سیستم</h2>

  <?php if (!empty($announces)): ?>
    <ul class="grid gap-6 md:grid-cols-2">
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
            
            <!-- Trigger button with auth check -->
            <button id="commentTrigger-<?= $announce['id'] ?>" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
              افزودن دیدگاه
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
      <h3 class="mt-4 text-lg font-medium text-gray-700">اعلانی وجود ندارد</h3>
    </div>
  <?php endif; ?>
</div>





<!-- Modal -->
<div id="commentModal-<?= $announce['id']?>" class=" fixed inset-0 z-50 hidden bg-black bg-opacity-50">
  <div class="modal-content absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg w-full max-w-md">
    <a href="#" class="close absolute top-2 right-2 text-2xl">&times;</a>
    <?php include views_path('iet_announce/comments/create.php'); ?>
  </div>
</div>