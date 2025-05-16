<?php isset($_SESSION['error'])?errorMessage():'' ?>

<div class="container mx-auto px-4 py-8">

  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">اتاق‌های گفتگو</h1>
  </div>

  <!-- Add Chat Room Form -->
  <div class="mb-8">
    <form action="<?= route('ietchats.room.store') ?>" method="POST" class="flex flex-wrap gap-4 items-end bg-gray-50 p-4 rounded shadow" dir="rtl">
      <?= csrf('field') ?>

    <div>
        <input
          type="hidden"
          name="creator_id"
          id="creator_id"
          required
          value="<?php echo $_SESSION['user_id'] ?>"
          class="border border-gray-300 px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>

      <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان اتاق</label>
        <input
          type="text"
          name="title"
          id="title"
          required
          class="border border-gray-300 px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
        <input
          type="text"
          name="description"
          id="description"
          class="border border-gray-300 px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>

      <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">دسته‌بندی</label>
        <select name="category_id" id="category_id" class="border border-gray-300 px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">بدون دسته‌بندی</option>
          <?php foreach ($categories as $cat): ?>
          
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['main_cate_id'].'-'.$cat['cate_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
      >
        ایجاد اتاق جدید
      </button>
    </form>
  </div>

  <!-- Chat Rooms Table -->
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if (!empty($rooms)): ?>
      <div class="overflow-x-auto">
   
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">ID</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">عنوان</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">توضیحات</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">دسته‌بندی</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">تاریخ ساخت</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">آخرین بروزرسانی</th>
              <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left">عملیات</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($rooms as $room): ?>
                
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $room['id'] ?></td>
                <td class="px-6 py-4 text-sm text-blue-600 hover:underline">
                  <a href="<?= route('ietchats.room.show', ['id' => $room['id']]) ?>">
                    <?= htmlspecialchars($room['title']) ?>
                  </a>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($room['description']) ?></td>
                <td class="px-6 py-4 text-sm text-gray-500">
                  <?= htmlspecialchars($room['category_id'] ?? '—') ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($room['created_at']) ?></td>
                <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($room['updated_at']) ?></td>
                <td class="px-4 py-2">
                  <form action="<?= route('ietchats.room.delete', ['id' => $room['id']]) ?>" method="POST" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این اتاق را حذف کنید؟');">
                    <?= csrf('field') ?>
                    <button type="submit" class="text-red-600 hover:underline">حذف</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="p-8 text-center text-gray-500">هیچ اتاقی ایجاد نشده است.</div>
    <?php endif; ?>
  </div>
</div>
