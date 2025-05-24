<?php
use App\HTMLRenderer\Navbar;

// Persian translation helper
function translateType($type, $context) {
    if ($context === 'supply_demand') {
        return $type === 'supply' ? 'عرضه' : 'تقاضا';
    }
    if ($context === 'goods_services') {
        return $type === 'goods' ? 'کالا' : 'خدمات';
    }
    return $type;
}
?>

<div class="max-w-5xl mx-auto p-6 space-y-6" dir="rtl">



  <!-- Header and Create Button -->
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">عرضه‌های من</h2>
    <a href="<?= route('ietannounce.create', ['sd' => 'supply']) ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition duration-150 ease-in-out transform hover:-translate-y-0.5 flex items-center gap-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      ثبت عرضه جدید
    </a>
  </div>

  <?php $announces = $data['my_supplies'] ?? []; ?>
  <?php if (!empty($announces)): ?>
    <div class="grid gap-4">
      <?php foreach ($announces as $announce): ?>
        <?php
          $announcer_id = $announce['user_id'];
          $commentModel = new App\Models\IETAnnounceComment();
          $announcer = $commentModel->fetchCommentor($announcer_id, 'username');
          $announcer_img = $commentModel->fetchCommentor($announcer_id, 'img');

          $subcategory_name = $announce['main_sub_cate_name'] ?? '---';
          $sd_label = translateType($announce['supply_demand'], 'supply_demand');
          $gs_label = translateType($announce['goods_services'], 'goods_services');
        ?>

        <div class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-l-4 <?= $announce['supply_demand'] === 'supply' ? 'border-blue-500' : 'border-green-500' ?>">
          <div class="flex items-center gap-3 mb-4">
            <img src="<?= htmlspecialchars($announcer_img) ?>" alt="User avatar" class="w-10 h-10 rounded-full object-cover border-2 border-blue-100">
            <a href="<?= route('user.profile', ['user_id' => $announcer_id, 'feature' => 'identification']) ?>" class="font-medium text-blue-600 hover:text-blue-800">
              <?= htmlspecialchars($announcer) ?>
            </a>
          </div>

          <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
            <div class="flex-1">
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($announce['title']) ?></h3>
                  <div class="flex flex-wrap gap-2 text-sm">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 font-medium rounded-full">
                      <?= htmlspecialchars($subcategory_name) ?>
                    </span>
                    <span class="px-2 py-1 <?= $announce['supply_demand'] === 'supply' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?> font-medium rounded-full">
                      <?= htmlspecialchars($sd_label) ?>
                    </span>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 font-medium rounded-full">
                      <?= htmlspecialchars($gs_label) ?>
                    </span>
                  </div>
                  <p class="text-sm text-gray-500 mt-2">واحد: <?= htmlspecialchars($announce['unit']) ?></p>
                </div>

                <div class="flex gap-2">
                  <a href="<?= route('ietannounce.show', ['id' => $announce['id']]) ?>" class="p-2 text-blue-600 hover:text-blue-800 transition-colors" title="مشاهده">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </a>
                </div>
              </div>
              <p class="text-gray-600 mt-3 leading-relaxed">
                <?= htmlspecialchars(mb_strimwidth(strip_tags($announce['description']), 0, 160, '...')) ?>
              </p>
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
      <h3 class="mt-4 text-lg font-medium text-gray-700">هیچ عرضه‌ای ثبت نشده است</h3>
      <p class="mt-1 text-gray-500">همین حالا اولین عرضه خود را ثبت کنید</p>
      <div class="mt-6">
        <a href="<?= route('ietannounce.create', ['sd' => 'supply']) ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors duration-200 inline-flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          ایجاد عرضه جدید
        </a>
      </div>
    </div>
  <?php endif; ?>
</div>
