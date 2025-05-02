<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow" dir="rtl">
  <h1 class="text-2xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($announce['title']) ?></h1>

  <p><strong>دسته‌بندی:</strong> <?= htmlspecialchars($announce['category']) ?></p>
  <p><strong>نوع:</strong> <?= htmlspecialchars($announce['supply_demand']) ?> / <?= htmlspecialchars($announce['goods_services']) ?></p>
  <p><strong>توضیحات:</strong> <?= nl2br(htmlspecialchars($announce['description'])) ?></p>
  <p><strong>قیمت پیشنهادی:</strong> <?= htmlspecialchars($announce['initial_suggested_price']) ?> تومان</p>
  <p><strong>مکان:</strong> <?= htmlspecialchars($announce['location_limit']) ?></p>

  <?php if (!empty($announce['media_paths'])): ?>
    <div class="mt-4 space-y-2">
      <?php foreach (json_decode($announce['media_paths'], true) as $url): ?>
        <div>
          <?php if (str_contains($url, '.mp4')): ?>
            <video src="<?= $url ?>" controls class="w-full rounded-lg"></video>
          <?php else: ?>
            <img src="<?= $url ?>" alt="media" class="w-full max-w-sm rounded-lg shadow">
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="mt-6 text-left">
    <a href="<?= route('ietannounce.edit', ['id' => $announce['id']]) ?>" class="text-blue-600 hover:underline">ویرایش</a>
  </div>
</div>
