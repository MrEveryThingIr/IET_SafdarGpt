<?= isset($_SESSION['error']) ? errorMessage() : '' ?>

<div class="container mx-auto px-4 py-8" dir="rtl">

  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">اتاق‌های گفتگو</h1>
  </div>

  <!-- Add Chat Room Form -->
  <section class="mb-8 bg-gray-50 p-4 rounded shadow">
    <form action="<?= route('ietchats.room.store') ?>" method="POST" class="flex flex-wrap gap-4 items-end">
      <?= csrf('field') ?>
      <input type="hidden" name="creator_id" value="<?= $_SESSION['user_id'] ?>">

      <!-- Title -->
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

      <!-- Description -->
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
        <input
          type="text"
          name="description"
          id="description"
          class="border border-gray-300 px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
      </div>

      <!-- Category Select -->
      <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
          دسته‌بندی فرعی <span class="text-red-500">*</span>
        </label>

        <select
          name="category_id"
          id="category_id"
          required
          class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled <?= empty($sub_category_name) ? 'selected' : '' ?>>انتخاب کنید</option>
          <?php foreach ($data['mainCategories'] as $mainCategory): ?>
            <optgroup label="<?= htmlspecialchars($mainCategory['cate_name']) ?>">
              <?php foreach ($data['sub_categories'][$mainCategory['id']]['sub_categories'] as $subCategory): ?>
                <option value="<?= htmlspecialchars($subCategory['id']) ?>"
                  <?= (isset($sub_category_name) && $sub_category_name === $subCategory['cate_name']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($subCategory['cate_name']) ?>
                </option>
              <?php endforeach; ?>
            </optgroup>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Submit -->
      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
      >
        ایجاد اتاق جدید
      </button>
    </form>
  </section>

  <!-- Joined Rooms -->
  <?php $joinedRooms = $data['my_chatrooms']['chatrooms_joined'] ?? []; ?>
  <section class="mb-12">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">گروه‌هایی که عضو شده‌ام</h2>
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <?php if (!empty($joinedRooms)): ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <?php foreach (['ID', 'عنوان', 'توضیحات', 'دسته‌بندی', 'تاریخ ساخت', 'آخرین بروزرسانی', 'عملیات'] as $header): ?>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left"><?= $header ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ($joinedRooms as $room): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 text-sm"><?= $room['id'] ?></td>
                  <td class="px-6 py-4 text-sm text-blue-600 hover:underline">
                    <a href="<?= route('ietchats.room.show', ['id' => $room['id']]) ?>">
                      <?= htmlspecialchars($room['title']) ?>
                    </a>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($room['description']) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($room['main_sub_cate_name'] ?? '—') ?></td>
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
        <div class="p-8 text-center text-gray-500">هیچ اتاقی برای شما ثبت نشده است.</div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Created Rooms -->
  <?php $createdRooms = $data['my_chatrooms']['chatrooms_created'] ?? []; ?>
  <section>
    <h2 class="text-xl font-semibold text-gray-700 mb-4">گروه‌هایی که ساخته‌ام</h2>
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <?php if (!empty($createdRooms)): ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <?php foreach (['ID', 'عنوان', 'توضیحات', 'دسته‌بندی', 'تاریخ ساخت', 'آخرین بروزرسانی', 'عملیات'] as $header): ?>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-left"><?= $header ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ($createdRooms as $room): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 text-sm"><?= $room['id'] ?></td>
                  <td class="px-6 py-4 text-sm text-blue-600 hover:underline">
                    <a href="<?= route('ietchats.room.show', ['id' => $room['id']]) ?>">
                      <?= htmlspecialchars($room['title']) ?>
                    </a>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($room['description']) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($room['main_sub_cate_name'] ?? '—') ?></td>
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
        <div class="p-8 text-center text-gray-500">هیچ اتاقی برای شما ثبت نشده است.</div>
      <?php endif; ?>
    </div>
  </section>
</div>
