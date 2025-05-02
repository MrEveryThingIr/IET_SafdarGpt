<div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow space-y-6" dir="rtl">
  <h2 class="text-2xl font-semibold text-gray-800">همه‌ی اعلام‌ها</h2>

  <?php if (!empty($announces)): ?>
    <ul class="space-y-4">
      <?php foreach ($announces as $announce): ?>
        <li class="bg-gray-100 p-4 rounded hover:bg-gray-50">
          <h3 class="text-lg font-bold"><?= htmlspecialchars($announce['title']) ?></h3>
          <p><?= htmlspecialchars($announce['category']) ?> | <?= htmlspecialchars($announce['supply_demand']) ?></p>
          <a href="<?= route('ietannounce.show', ['id' => $announce['id']]) ?>" class="text-blue-500 hover:underline">مشاهده</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>اعلانی وجود ندارد.</p>
  <?php endif; ?>
</div>
