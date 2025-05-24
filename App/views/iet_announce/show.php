<?php
// Helper: Translate ENUMs to Persian
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

<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md" dir="rtl">

  <!-- Header -->
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($announce['title']) ?></h1>
    <div class="flex items-center gap-2 text-gray-500">
      <span class="text-sm"><?= date('Y/m/d', strtotime($announce['created_at'])) ?></span>
    </div>
  </div>

  <!-- Grid Info -->
  <div class="grid gap-4 md:grid-cols-2 mb-8">
    <div class="space-y-4">
      <div class="bg-blue-50 p-4 rounded-lg">
        <h3 class="font-semibold text-blue-800 mb-2">دسته‌بندی</h3>
        <p class="text-gray-700"><?= htmlspecialchars($announce['category'] ?? '---') ?></p>
      </div>

      <div class="bg-green-50 p-4 rounded-lg">
        <h3 class="font-semibold text-green-800 mb-2">نوع</h3>
        <p class="text-gray-700">
          <?= translateType($announce['supply_demand'], 'supply_demand') ?> /
          <?= translateType($announce['goods_services'], 'goods_services') ?>
        </p>
      </div>

      <div class="bg-yellow-50 p-4 rounded-lg">
        <h3 class="font-semibold text-yellow-800 mb-2">محدوده مکانی</h3>
        <p class="text-gray-700"><?= htmlspecialchars($announce['location_limit'] ?? '---') ?></p>
      </div>

      <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-800 mb-2">واحد</h3>
        <p class="text-gray-700"><?= htmlspecialchars($announce['unit']) ?></p>
      </div>
    </div>

    <div class="space-y-4">
      <div class="bg-purple-50 p-4 rounded-lg">
        <h3 class="font-semibold text-purple-800 mb-2">قیمت پیشنهادی</h3>
        <p class="text-gray-700">
          <?= is_numeric($announce['initial_suggested_price']) ? number_format((float) $announce['initial_suggested_price']) . ' تومان' : '---' ?>
        </p>
      </div>

      <?php if (!empty($announce['start_date'])): ?>
        <div class="bg-blue-100 p-4 rounded-lg">
          <h3 class="font-semibold text-blue-900 mb-2">تاریخ شروع</h3>
          <p class="text-gray-700"><?= date('Y/m/d H:i', strtotime($announce['start_date'])) ?></p>
        </div>
      <?php endif; ?>

      <?php if (!empty($announce['end_date'])): ?>
        <div class="bg-red-100 p-4 rounded-lg">
          <h3 class="font-semibold text-red-900 mb-2">تاریخ پایان</h3>
          <p class="text-gray-700"><?= date('Y/m/d H:i', strtotime($announce['end_date'])) ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Description -->
  <div class="mb-8">
    <h3 class="text-xl font-semibold text-gray-800 mb-3">توضیحات</h3>
    <div class="bg-gray-50 p-4 rounded-lg prose max-w-none leading-relaxed text-gray-700">
      <?= nl2br(htmlspecialchars($announce['description'])) ?>
    </div>
  </div>

  <!-- Media -->
  <?php if (!empty($announce['media_paths'])): ?>
    <div class="mb-8">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">گالری رسانه</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <?php foreach (json_decode($announce['media_paths'], true) as $url): ?>
          <div class="rounded-xl overflow-hidden shadow-md border border-gray-200">
            <?php if (str_contains($url, '.mp4')): ?>
              <video src="<?= $url ?>" controls class="w-full h-auto max-h-96 object-cover"></video>
            <?php else: ?>
              <img src="<?= $url ?>" alt="media" class="w-full h-auto max-h-96 object-cover hover:scale-105 transition-transform duration-300 cursor-zoom-in">
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <!-- Flash Messages -->
  <div class="space-y-3 mb-6">
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
        <?= $_SESSION['success'] ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
        <?= $_SESSION['error'] ?>
      </div>
    <?php endif; ?>

    <?php
      $_SESSION['success'] = null;
      $_SESSION['error'] = null;
    ?>
  </div>

  <!-- Comment Form -->
  <div class="mb-10">
    <?php include views_path('iet_announce/comments/create.php'); ?>
  </div>

  <!-- Comments -->
  <div class="border-t pt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
      نظرات (<?= count($comments) ?>)
    </h2>

    <?php if (!empty($comments)): ?>
      <div class="space-y-5">
        <?php foreach ($comments as $comment): ?>
          <?php
            $commentor_id = $comment['commentor_id'];
            $commentModel = new \App\Models\IETAnnounceComment();
            $commentor = $commentModel->fetchCommentor($commentor_id, 'username');
            $commentor_img = $commentModel->fetchCommentor($commentor_id, 'img');
          ?>
          <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex gap-4">
              <div class="flex-shrink-0">
                <img src="<?= $commentor_img ?>" alt="User avatar" class="w-12 h-12 rounded-full object-cover border-2 border-blue-100">
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                  <a href="<?= route('user.profile', ['user_id' => $commentor_id, 'feature' => 'identification']) ?>" class="font-medium text-blue-600 hover:text-blue-800">
                    <?= htmlspecialchars($commentor) ?>
                  </a>
                  <span class="text-xs text-gray-500">
                    <?= date('Y/m/d H:i', strtotime($comment['created_at'])) ?>
                  </span>
                </div>
                <div class="prose prose-sm text-gray-700">
                  <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center py-10 bg-gray-50 rounded-xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <h3 class="mt-3 text-gray-600 font-medium">هیچ نظری ثبت نشده است</h3>
        <p class="text-gray-500 mt-1">اولین نفری باشید که نظر می‌دهد</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- Actions -->
  <div class="mt-8 flex justify-end gap-3">
    <a href="<?= route('ietannounce.all') ?>" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
      بازگشت به لیست
    </a>
    <a href="<?= route('ietannounce.edit', ['id' => $announce['id']]) ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
      </svg>
      ویرایش آگهی
    </a>
  </div>
</div>
