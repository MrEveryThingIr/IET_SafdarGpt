<div class="max-w-5xl mx-auto p-6 bg-white rounded-lg shadow space-y-6" dir="rtl">
  <h2 class="text-2xl font-semibold text-gray-800">اعلام‌های من</h2>
  <?php if (!empty($announces)): ?>
    <ul class="space-y-4">
      <?php foreach ($announces as $announce): ?>
        <li class="bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md transition">
          <div class="flex justify-between items-center">
            <div>
                <a href="<?php echo route('ietannounce.show',['id'=>$announce['id']])?>">
                <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($announce['title']) ?></h3>
                </a>
            
              <p class="text-sm text-gray-600"><?= htmlspecialchars($announce['category']) ?> | <?= htmlspecialchars($announce['supply_demand']) ?> | <?= htmlspecialchars($announce['goods_services']) ?></p>
              <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($announce['description']) ?></p>
            </div>
            <div class="flex space-x-2">
              <a href="<?= route('ietannounce.edit', ['id' => $announce['id']]) ?>" class="text-blue-600 hover:text-blue-800">ویرایش</a>
              <form action="<?= route('ietannounce.delete', ['id' => $announce['id']]) ?>" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟');">
                <button type="submit" class="text-red-600 hover:text-red-800">حذف</button>
              </form>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-gray-600">هیچ اعلامی ثبت نشده است.</p>
  <?php endif; ?>
</div>
