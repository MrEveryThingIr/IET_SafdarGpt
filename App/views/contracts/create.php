<form action="<?php  ?>" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow space-y-6 text-right" dir="rtl">
  <!-- Contract Title -->
  <div>
    <label for="contract_title" class="block text-sm font-medium text-gray-700 mb-1">عنوان قرارداد <span class="text-red-500">*</span></label>
    <input type="text" name="contract_title" id="contract_title" required minlength="5"
           class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
           placeholder="عنوان قرارداد را وارد کنید">
  </div>

  <!-- Contract Type -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">نوع قرارداد <span class="text-red-500">*</span></label>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <label class="flex items-center">
        <input type="radio" name="contract_type" value="service" required class="form-radio"> 
        <span class="mr-2">قرارداد خدمات</span>
      </label>
      <label class="flex items-center">
        <input type="radio" name="contract_type" value="goods" class="form-radio"> 
        <span class="mr-2">قرارداد کالا</span>
      </label>
      <label class="flex items-center">
        <input type="radio" name="contract_type" value="employment" class="form-radio"> 
        <span class="mr-2">قرارداد کاری</span>
      </label>
    </div>
  </div>

  <!-- Contract Parties -->
  <div class="border border-gray-200 rounded-lg p-4">
    <h3 class="text-lg font-medium text-gray-800 mb-4">طرفین قرارداد <span class="text-red-500">*</span></h3>
    
    <!-- First Party -->
    <div class="mb-4">
      <label for="first_party" class="block text-sm font-medium text-gray-700 mb-1">طرف اول (پیشنهاد دهنده)</label>
      <select name="first_party" id="first_party" required
              class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
        <option value="">انتخاب کنید</option>
        <?php foreach($users as $user): ?>
          <option value="<?= $user['id'] ?>"><?= $user['name'] ?> (<?= $user['username'] ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <!-- Second Party -->
    <div class="mb-4">
      <label for="second_party" class="block text-sm font-medium text-gray-700 mb-1">طرف دوم (پذیرنده)</label>
      <select name="second_party" id="second_party" required
              class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
        <option value="">انتخاب کنید</option>
        <?php foreach($users as $user): ?>
          <option value="<?= $user['id'] ?>"><?= $user['name'] ?> (<?= $user['username'] ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <!-- Additional Parties -->
    <div id="additional_parties_container" class="hidden">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm font-medium text-gray-700">طرف‌های اضافی</h4>
        <button type="button" id="add_party_btn" class="text-blue-600 text-sm">+ افزودن طرف</button>
      </div>
      <div id="additional_parties_list"></div>
    </div>
    
    <label class="flex items-center mt-2">
      <input type="checkbox" id="has_additional_parties" name="has_additional_parties" class="form-checkbox">
      <span class="mr-2 text-sm text-gray-700">این قرارداد شامل طرف‌های اضافی می‌شود</span>
    </label>
  </div>

  <!-- Contract Terms -->
  <div>
    <label for="contract_terms" class="block text-sm font-medium text-gray-700 mb-1">شرایط و مفاد قرارداد <span class="text-red-500">*</span></label>
    <textarea name="contract_terms" id="contract_terms" rows="8" required
              class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
              placeholder="مفاد قرارداد را به صورت دقیق و شفاف شرح دهید"></textarea>
  </div>

  <!-- Contract Duration -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">تاریخ شروع <span class="text-red-500">*</span></label>
      <input type="date" name="start_date" id="start_date" required
             class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
      <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">تاریخ پایان</label>
      <input type="date" name="end_date" id="end_date"
             class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
    </div>
  </div>

  <!-- Payment Terms -->
  <div class="border border-gray-200 rounded-lg p-4">
    <h3 class="text-lg font-medium text-gray-800 mb-4">شرایط پرداخت</h3>
    
    <div class="mb-4">
      <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">مبلغ قرارداد (تومان)</label>
      <input type="number" name="payment_amount" id="payment_amount"
             class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
    </div>
    
    <div class="mb-4">
      <label for="payment_schedule" class="block text-sm font-medium text-gray-700 mb-1">زمان‌بندی پرداخت</label>
      <select name="payment_schedule" id="payment_schedule"
              class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500">
        <option value="full_upfront">پرداخت کامل پیش از شروع</option>
        <option value="full_after">پرداخت کامل پس از اتمام</option>
        <option value="installments">پرداخت اقساطی</option>
        <option value="custom">زمان‌بندی سفارشی</option>
      </select>
    </div>
    
    <div id="custom_payment_schedule" class="hidden mt-4">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm font-medium text-gray-700">زمان‌بندی سفارشی پرداخت</h4>
        <button type="button" id="add_payment_btn" class="text-blue-600 text-sm">+ افزودن مرحله پرداخت</button>
      </div>
      <div id="payment_schedule_list"></div>
    </div>
  </div>

  <!-- Attachments -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">ضمایم قرارداد</label>
    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
      <input type="file" name="contract_attachments[]" id="contract_attachments" multiple
             class="hidden">
      <label for="contract_attachments" class="flex flex-col items-center justify-center cursor-pointer">
        <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
        <p class="text-gray-600">برای آپلود فایل‌ها کلیک کنید یا آنها را اینجا رها کنید</p>
        <p class="text-sm text-gray-500 mt-1">فرمت‌های مجاز: PDF, DOCX, JPG, PNG (حداکثر 5MB هر فایل)</p>
      </label>
      <div id="file_preview_container" class="mt-4 space-y-2"></div>
    </div>
  </div>

  <!-- Terms and Conditions -->
  <div class="border-t border-gray-200 pt-4">
    <label class="flex items-start">
      <input type="checkbox" name="agree_terms" required
             class="mt-1 form-checkbox">
      <span class="mr-2 text-sm text-gray-700">با <a href="#" class="text-blue-600 hover:underline">شرایط و قوانین</a> سیستم قراردادهای الکترونیکی موافقم</span>
    </label>
  </div>

  <!-- Submit Button -->
  <div class="text-center pt-4">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium">
      ایجاد قرارداد
    </button>
  </div>
</form>

<!-- Template for Additional Parties -->
<template id="party_template">
  <div class="party-item flex items-center gap-3 mb-2">
    <select name="additional_parties[]" class="flex-1 border border-gray-300 rounded p-2">
      <option value="">انتخاب کاربر</option>
      <?php foreach($users as $user): ?>
        <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
      <?php endforeach; ?>
    </select>
    <button type="button" class="remove-party-btn text-red-500 hover:text-red-700">
      <i class="fas fa-times"></i>
    </button>
  </div>
</template>

<!-- Template for Payment Schedule -->
<template id="payment_template">
  <div class="payment-item grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
    <div>
      <label class="block text-xs text-gray-500 mb-1">عنوان مرحله</label>
      <input type="text" name="payment_titles[]" class="w-full border border-gray-300 rounded p-2 text-sm">
    </div>
    <div>
      <label class="block text-xs text-gray-500 mb-1">مبلغ (تومان)</label>
      <input type="number" name="payment_amounts[]" class="w-full border border-gray-300 rounded p-2 text-sm">
    </div>
    <div>
      <label class="block text-xs text-gray-500 mb-1">تاریخ پرداخت</label>
      <input type="date" name="payment_dates[]" class="w-full border border-gray-300 rounded p-2 text-sm">
    </div>
  </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle additional parties
  const hasAdditionalParties = document.getElementById('has_additional_parties');
  const additionalPartiesContainer = document.getElementById('additional_parties_container');
  
  hasAdditionalParties.addEventListener('change', function() {
    additionalPartiesContainer.classList.toggle('hidden', !this.checked);
  });

  // Add additional party
  const addPartyBtn = document.getElementById('add_party_btn');
  const additionalPartiesList = document.getElementById('additional_parties_list');
  const partyTemplate = document.getElementById('party_template');
  
  addPartyBtn.addEventListener('click', function() {
    const partyClone = partyTemplate.content.cloneNode(true);
    const removeBtn = partyClone.querySelector('.remove-party-btn');
    
    removeBtn.addEventListener('click', function() {
      this.closest('.party-item').remove();
    });
    
    additionalPartiesList.appendChild(partyClone);
  });

  // Toggle custom payment schedule
  const paymentSchedule = document.getElementById('payment_schedule');
  const customPaymentSchedule = document.getElementById('custom_payment_schedule');
  
  paymentSchedule.addEventListener('change', function() {
    customPaymentSchedule.classList.toggle('hidden', this.value !== 'custom');
  });

  // Add payment schedule item
  const addPaymentBtn = document.getElementById('add_payment_btn');
  const paymentScheduleList = document.getElementById('payment_schedule_list');
  const paymentTemplate = document.getElementById('payment_template');
  
  addPaymentBtn.addEventListener('click', function() {
    paymentScheduleList.appendChild(paymentTemplate.content.cloneNode(true));
  });

  // File upload preview
  const fileInput = document.getElementById('contract_attachments');
  const filePreviewContainer = document.getElementById('file_preview_container');
  
  fileInput.addEventListener('change', function() {
    filePreviewContainer.innerHTML = '';
    
    Array.from(this.files).forEach(file => {
      const filePreview = document.createElement('div');
      filePreview.className = 'flex items-center justify-between bg-gray-50 p-2 rounded';
      
      filePreview.innerHTML = `
        <div class="flex items-center gap-2">
          <i class="fas fa-file text-gray-500"></i>
          <span class="text-sm truncate max-w-xs">${file.name}</span>
          <span class="text-xs text-gray-500">(${(file.size / 1024 / 1024).toFixed(2)}MB)</span>
        </div>
        <button type="button" class="text-red-500 hover:text-red-700 text-sm">
          <i class="fas fa-times"></i>
        </button>
      `;
      
      filePreview.querySelector('button').addEventListener('click', function() {
        // Remove the file from the input
        const dt = new DataTransfer();
        Array.from(fileInput.files).forEach(f => {
          if (f !== file) dt.items.add(f);
        });
        fileInput.files = dt.files;
        
        // Remove the preview
        filePreview.remove();
      });
      
      filePreviewContainer.appendChild(filePreview);
    });
  });
});
</script>