<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow space-y-6" dir="rtl">
  <form action="<?= route('ietannounce.update', ['id' => $announce['id']]) ?>" method="POST" enctype="multipart/form-data">
    <!-- You can re-use the same form layout as in create.php, pre-filling values with $announce['key'] -->
    <div>
      <label class="block font-medium">عنوان</label>
      <input name="title" value="<?= htmlspecialchars($announce['title']) ?>" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label class="block font-medium">توضیحات</label>
      <textarea name="description" rows="4" class="w-full border rounded p-2"><?= htmlspecialchars($announce['description']) ?></textarea>
    </div>

    <!-- Add the rest of fields like category, supply_demand, price, etc... -->

    <div class="mt-4">
      <label class="block">افزودن فایل جدید (در صورت نیاز)</label>
      <input
    type="file"
    name="media_uploads[]"
    id="media_upload"
    multiple
    accept="image/*,video/*"
    class="block mt-2"
  >

  <div id="media_preview" class="mt-4 flex gap-2 flex-wrap"></div>
    </div>

    <?php if (!empty($mediaUrls)): ?>
      <div>
        <label class="block font-medium">فایل‌های فعلی</label>
        <div id="existingMediaContainer" class="flex flex-wrap gap-4 mt-2"></div>
        <p class="text-sm text-gray-500 mt-1">برای حذف فایل، تیک آن را بردارید.</p>
      </div>
    <?php endif; ?>


    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded mt-4">بروزرسانی</button>
  </form>
</div>

<script>
  window._EXISTING_MEDIA = <?= $existingMediaJs ?? '[]' ?>;
</script>
