<!-- Flash Messages -->
<div class="space-y-2">
  <?= isset($_SESSION['error']) ? errorMessage() : '' ?>
  <?= isset($_SESSION['success']) ? successMessage() : '' ?>
</div>

<form action="<?= route('ietannounce.store',['sd'=>$sd]) ?>" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow space-y-6 text-right" dir="rtl">
  <?= csrf('field'); ?>

  <!-- عرضه یا تقاضا -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">عرضه یا تقاضا <span class="text-red-500">*</span></label>
    <div class="flex space-x-reverse space-x-4">
      <label>
        <input type="radio" name="supply_demand" value="supply" required class="form-radio" <?= ($sd && $sd == 'supply') ? 'checked' : '' ?>>
        <span class="ml-2">عرضه</span>
      </label>
      <label>
        <input type="radio" name="supply_demand" value="demand" required class="form-radio" <?= ($sd && $sd == 'demand') ? 'checked' : '' ?>>
        <span class="ml-2">تقاضا</span>
      </label>
    </div>
  </div>

  <!-- نوع مورد -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">نوع مورد <span class="text-red-500">*</span></label>
    <div class="flex space-x-reverse space-x-4">
      <label>
        <input type="radio" name="goods_services" value="goods" required class="form-radio" >
        <span class="ml-2">کالا</span>
      </label>
      <label>
        <input type="radio" name="goods_services" value="services" required class="form-radio" >
        <span class="ml-2">خدمات</span>
      </label>
    </div>
  </div>

<!-- دسته‌بندی فرعی -->
<div>
  <label for="sub_category_name" class="block text-sm font-medium text-gray-700 mb-1">
    دسته‌بندی فرعی <span class="text-red-500">*</span>
  </label>

  <select name="sub_category_id" id="sub_category_id" 
          required 
          class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
    <option value="" disabled <?= empty($sub_category_name) ? 'selected' : '' ?>>
      انتخاب کنید
    </option>

    <?php foreach ($categories['main'] as $mainCategory): ?>
      <optgroup label="<?= htmlspecialchars($mainCategory['cate_name']) ?>">
        <?php foreach ($categories['sub'][$mainCategory['id']]['sub_categories'] as $subCategory): ?>
          <option value="<?= htmlspecialchars($subCategory['id']) ?>"
            <?= (isset($sub_category_name) && $sub_category_name === $subCategory['cate_name']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($subCategory['cate_name']) ?>
          </option>
        <?php endforeach; ?>
      </optgroup>
    <?php endforeach; ?>
  </select>
</div>


  <!-- عنوان -->
  <div>
    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان <span class="text-red-500">*</span></label>
    <input type="text" name="title" id="title" required minlength="2"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="مثلاً پخت چلو خانگی" value="<?= htmlspecialchars($title ?? '') ?>">
  </div>

  <!-- واحد -->
  <div>
    <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">واحد <span class="text-red-500">*</span></label>
    <input type="text" name="unit" id="unit" required minlength="2"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="مثلاً به ازای هر پرس غذا، به ازای هر ساعت یا روز کار..." value="<?= htmlspecialchars($unit ?? '') ?>">
  </div>

  <!-- توضیحات -->
  <div>
    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">توضیحات بیشتر</label>
    <textarea name="description" id="description" rows="4"
              class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
              placeholder="ویژگی‌ها، تعداد، کیفیت..."><?= htmlspecialchars($description ?? '') ?></textarea>
  </div>

  <!-- قیمت پیشنهادی -->
  <div>
    <label for="initial_suggested_price" class="block text-sm font-medium text-gray-700 mb-1">قیمت پیشنهادی</label>
    <input type="number" name="initial_suggested_price" id="initial_suggested_price"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="تومان" value="<?= htmlspecialchars($initial_suggested_price ?? '') ?>">
  </div>

  <!-- دوره زمانی -->
  <fieldset class="border border-gray-300 rounded-lg p-4">
    <legend class="text-sm font-medium text-gray-700 px-2">دوره زمانی قابل عرضه یا مورد تقاضا</legend>
    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-reverse md:space-x-4 items-center">
      <!-- From Date/Time -->
      <div class="flex flex-col">
        <label for="start_date" class="text-sm text-gray-600 mb-1">از</label>
        <input type="datetime-local" id="start_date" name="start_date" 
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
               value="<?= htmlspecialchars($start_date ?? '') ?>">
      </div>

      <!-- To Date/Time -->
      <div class="flex flex-col">
        <label for="end_date" class="text-sm text-gray-600 mb-1">تا</label>
        <input type="datetime-local" id="end_date" name="end_date" 
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
               value="<?= htmlspecialchars($end_date ?? '') ?>">
      </div>
    </div>
  </fieldset>

  <!-- محدودیت مکانی -->
  <div>
    <label for="location_limit" class="block text-sm font-medium text-gray-700 mb-1">مکان (در صورت محدودیت)</label>
    <input type="text" name="location_limit" id="location_limit"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="مثلاً فقط تهران" value="<?= htmlspecialchars($location_limit ?? '') ?>">
  </div>

<!-- فایل ضمیمه -->
<div>
  <label for="mediaUploaderInput" class="block text-sm font-medium text-gray-700 mb-1">فایل‌های ضمیمه</label>
  <input type="file" name="media_uploads[]" id="mediaUploaderInput" multiple
         class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
  <div id="uploadedMediaList" class="mt-2 flex flex-wrap gap-2"></div>
</div>


  <!-- دکمه ثبت -->
  <div class="text-center">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
      ثبت اعلام
    </button>
  </div>
</form>

