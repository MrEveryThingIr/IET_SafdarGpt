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

  <!-- Comments Section -->
  <div class="mt-8 border-t pt-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center">
      <i class="fas fa-comments mr-2 text-blue-500"></i>
      نظرات (<?= count($comments) ?>)
    </h2>

    <?php if (!empty($comments)): ?>
      <div class="space-y-6">
        <?php foreach ($comments as $comment): ?>
          <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <div class="flex items-start gap-3">
              <div class="bg-blue-100 text-blue-800 rounded-full w-10 h-10 flex items-center justify-center">
                <i class="fas fa-user"></i>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
              <?php
              $commentor_id=$comment['commentor_id'];
              $commentor=(new App\Models\IETAnnounceComment())->fetchCommentor($commentor_id,'username'); 
              ?>
                  <a href="<?php echo route('user.profile',['feature'=>'identification']) ?>"><span class="font-medium">کاربر <?= $commentor ?></span></a>
                  <span class="text-xs text-gray-500">
                    <?= date('Y/m/d H:i', strtotime($comment['created_at'])) ?>
                  </span>
                </div>
                <p class="mt-2 text-gray-700 whitespace-pre-line"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center py-8 text-gray-500">
        <i class="fas fa-comment-slash text-3xl mb-2"></i>
        <p>هنوز نظری ثبت نشده است</p>
      </div>
    <?php endif; ?>
  <div class="mt-6 text-left">
    <a href="<?= route('ietannounce.edit', ['id' => $announce['id']]) ?>" class="text-blue-600 hover:underline">ویرایش</a>
  </div>
</div>
