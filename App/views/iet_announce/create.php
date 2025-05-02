<form action="<?= route('ietannounce.store') ?>" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow space-y-6 text-right" dir="rtl">
  <!-- عرضه یا تقاضا -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">عرضه یا تقاضا <span class="text-red-500">*</span></label>
    <div class="flex space-x-reverse space-x-4">
      <label><input type="radio" name="supply_demand" value="supply" required class="form-radio"> <span class="ml-2">عرضه</span></label>
      <label><input type="radio" name="supply_demand" value="demand" class="form-radio"> <span class="ml-2">تقاضا</span></label>
    </div>
  </div>

  <!-- نوع مورد -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">نوع مورد <span class="text-red-500">*</span></label>
    <div class="flex space-x-reverse space-x-4">
      <label><input type="radio" name="goods_services" value="goods" required class="form-radio"> <span class="ml-2">کالا</span></label>
      <label><input type="radio" name="goods_services" value="services" class="form-radio"> <span class="ml-2">خدمات</span></label>
    </div>
  </div>

  <!-- دسته‌بندی اصلی -->
  <div>
    <label for="main_category" class="block text-sm font-medium text-gray-700 mb-1">دسته‌بندی اصلی</label>
    <input list="main_categories" name="main_category" id="main_category"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="مثلاً غذا و خوراکی">
    <datalist id="main_categories"></datalist>
  </div>

  <!-- دسته‌بندی فرعی -->
  <div>
    <label for="sub_category" class="block text-sm font-medium text-gray-700 mb-1">دسته‌بندی فرعی</label>
    <input list="sub_categories" name="sub_category" id="sub_category"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="مثلاً چلو، آموزش زبان...">
    <datalist id="sub_categories"></datalist>
  </div>

  <!-- عنوان -->
  <div>
    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان</label>
    <input type="text" name="title" id="title" required minlength="2"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="مثلاً پخت چلو خانگی">
  </div>

  <!-- توضیحات -->
  <div>
    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">توضیحات بیشتر</label>
    <textarea name="description" id="description" rows="4"
              class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
              placeholder="ویژگی‌ها، تعداد، کیفیت..."></textarea>
  </div>

  <!-- قیمت پیشنهادی -->
  <div>
    <label for="initial_suggested_price" class="block text-sm font-medium text-gray-700 mb-1">قیمت پیشنهادی</label>
    <input type="number" name="initial_suggested_price" id="initial_suggested_price"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500" placeholder="تومان">
  </div>

  <!-- محدودیت مکانی -->
  <div>
    <label for="location_limit" class="block text-sm font-medium text-gray-700 mb-1">مکان (در صورت محدودیت)</label>
    <input type="text" name="location_limit" id="location_limit"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="مثلاً فقط تهران">
  </div>

  <!-- فایل ضمیمه -->
  <div>
  <label for="media_upload" class="block text-sm font-medium text-gray-700 mb-1">فایل‌های ضمیمه</label>
  <input type="file" name="media_uploads[]" id="media_upload" accept="image/*,video/*" multiple
         class="w-full border border-dashed border-gray-400 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

  <p class="text-xs text-gray-500 mt-1">حداکثر ۵ عکس یا ویدیو</p>

  <!-- Preview Container -->
  <div id="media_preview" class="mt-4 flex flex-wrap gap-4"></div>
</div>

  <!-- دکمه ثبت -->
  <div class="text-center">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
      ثبت اعلام
    </button>
  </div>
</form>

<script>
  // Add this to your main form JS
document.querySelector('form').addEventListener('submit', function(e) {
  // Debug: Log files before submission
  const fileInput = document.querySelector('input[name="media_uploads[]"]');
  console.log('Submitting files:', fileInput.files);
  
  // Optional: Add loading state
  const submitBtn = this.querySelector('button[type="submit"]');
  submitBtn.disabled = true;
  submitBtn.innerHTML = 'در حال آپلود...';
});
</script>