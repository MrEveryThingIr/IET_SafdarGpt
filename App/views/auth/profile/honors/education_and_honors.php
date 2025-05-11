<form action="#" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow space-y-6 text-right" dir="rtl">
  <!-- تحصیلات -->
  <div class="border-b pb-4">
    <h2 class="text-xl font-bold text-gray-800 mb-4">تحصیلات</h2>
    
    <!-- سطح تحصیلات -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-2">سطح تحصیلات <span class="text-red-500">*</span></label>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <label class="flex items-center">
          <input type="radio" name="education_level" value="illiterate" required class="form-radio"> 
          <span class="mr-2">بی‌سواد</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="elementary" class="form-radio"> 
          <span class="mr-2">ابتدایی</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="middle_school" class="form-radio"> 
          <span class="mr-2">سیکل</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="diploma" class="form-radio"> 
          <span class="mr-2">دیپلم</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="associate" class="form-radio"> 
          <span class="mr-2">فوق دیپلم</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="bachelor" class="form-radio"> 
          <span class="mr-2">لیسانس</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="master" class="form-radio"> 
          <span class="mr-2">فوق لیسانس</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="phd" class="form-radio"> 
          <span class="mr-2">دکتری</span>
        </label>
        <label class="flex items-center">
          <input type="radio" name="education_level" value="postdoc" class="form-radio"> 
          <span class="mr-2">پسادکتری</span>
        </label>
      </div>
    </div>

    <!-- جزئیات تحصیلی -->
    <div id="education_details" class="hidden space-y-4">
      <!-- رشته تحصیلی -->
      <div>
        <label for="field_of_study" class="block text-sm font-medium text-gray-700 mb-1">رشته تحصیلی</label>
        <input type="text" name="field_of_study" id="field_of_study"
               class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
               placeholder="مثلاً مهندسی کامپیوتر">
      </div>

      <!-- دانشگاه/موسسه -->
      <div>
        <label for="institution" class="block text-sm font-medium text-gray-700 mb-1">دانشگاه/موسسه</label>
        <input type="text" name="institution" id="institution"
               class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
               placeholder="نام دانشگاه یا موسسه آموزشی">
      </div>

      <!-- سال فارغ التحصیلی -->
      <div>
        <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-1">سال فارغ‌التحصیلی</label>
        <input type="number" name="graduation_year" id="graduation_year" min="1300" max="1405"
               class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
               placeholder="مثلاً 1398">
      </div>

      <!-- معدل -->
      <div>
        <label for="gpa" class="block text-sm font-medium text-gray-700 mb-1">معدل</label>
        <input type="number" step="0.01" min="0" max="20" name="gpa" id="gpa"
               class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500"
               placeholder="مثلاً 17.5">
      </div>

      <!-- مدارک تحصیلی -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مدارک تحصیلی</label>
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
          <input type="file" name="education_documents[]" id="education_documents" multiple
                 class="hidden" accept=".pdf,.jpg,.jpeg,.png">
          <label for="education_documents" class="flex flex-col items-center justify-center cursor-pointer">
            <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
            <p class="text-gray-600">برای آپلود مدارک کلیک کنید</p>
            <p class="text-sm text-gray-500 mt-1">فرمت‌های مجاز: PDF, JPG, PNG (حداکثر 5MB هر فایل)</p>
          </label>
          <div id="education_docs_preview" class="mt-4 space-y-2"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- دوره‌های تخصصی و مهارتی -->
  <div class="border-b pb-4">
    <h2 class="text-xl font-bold text-gray-800 mb-4">دوره‌های تخصصی و مهارتی</h2>
    
    <div id="courses_container">
      <!-- دوره‌ها به صورت داینامیک اضافه خواهند شد -->
      <div class="course-item border border-gray-200 rounded-lg p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">عنوان دوره</label>
            <input type="text" name="courses[0][title]" class="w-full border border-gray-300 rounded p-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">سطح مهارت</label>
            <select name="courses[0][level]" class="w-full border border-gray-300 rounded p-2">
              <option value="beginner">مقدماتی</option>
              <option value="intermediate">متوسط</option>
              <option value="advanced">پیشرفته</option>
              <option value="expert">تخصصی</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">موسسه برگزارکننده</label>
            <input type="text" name="courses[0][institution]" class="w-full border border-gray-300 rounded p-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">سال گذراندن</label>
            <input type="number" name="courses[0][year]" min="1300" max="1405" class="w-full border border-gray-300 rounded p-2">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">مدرک دوره</label>
            <input type="file" name="courses[0][certificate]" class="w-full border border-gray-300 rounded p-2">
          </div>
        </div>
      </div>
    </div>
    
    <button type="button" id="add_course_btn" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
      <i class="fas fa-plus ml-1"></i> افزودن دوره جدید
    </button>
  </div>

  <!-- افتخارات و گواهینامه‌ها -->
  <div class="border-b pb-4">
    <h2 class="text-xl font-bold text-gray-800 mb-4">افتخارات و گواهینامه‌ها</h2>
    
    <div id="achievements_container">
      <!-- افتخارات به صورت داینامیک اضافه خواهند شد -->
      <div class="achievement-item border border-gray-200 rounded-lg p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">عنوان افتخار/گواهینامه</label>
            <input type="text" name="achievements[0][title]" class="w-full border border-gray-300 rounded p-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">سطح</label>
            <select name="achievements[0][level]" class="w-full border border-gray-300 rounded p-2">
              <option value="local">محلی</option>
              <option value="provincial">استانی</option>
              <option value="national">ملی</option>
              <option value="international">بین‌المللی</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">سال دریافت</label>
            <input type="number" name="achievements[0][year]" min="1300" max="1405" class="w-full border border-gray-300 rounded p-2">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">مرجع اعطاکننده</label>
            <input type="text" name="achievements[0][issuer]" class="w-full border border-gray-300 rounded p-2">
          </div>
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">مدرک/تصویر گواهینامه</label>
            <input type="file" name="achievements[0][document]" class="w-full border border-gray-300 rounded p-2">
          </div>
        </div>
      </div>
    </div>
    
    <button type="button" id="add_achievement_btn" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
      <i class="fas fa-plus ml-1"></i> افزودن افتخار جدید
    </button>
  </div>

  <!-- زبان‌ها -->
  <div>
    <h2 class="text-xl font-bold text-gray-800 mb-4">مهارت‌های زبانی</h2>
    
    <div id="languages_container">
      <!-- زبان‌ها به صورت داینامیک اضافه خواهند شد -->
      <div class="language-item border border-gray-200 rounded-lg p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">زبان</label>
            <select name="languages[0][name]" class="w-full border border-gray-300 rounded p-2">
              <option value="english">انگلیسی</option>
              <option value="french">فرانسوی</option>
              <option value="german">آلمانی</option>
              <option value="spanish">اسپانیایی</option>
              <option value="arabic">عربی</option>
              <option value="chinese">چینی</option>
              <option value="russian">روسی</option>
              <option value="other">سایر</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">سطح خواندن</label>
            <select name="languages[0][reading]" class="w-full border border-gray-300 rounded p-2">
              <option value="basic">پایه</option>
              <option value="intermediate">متوسط</option>
              <option value="advanced">پیشرفته</option>
              <option value="fluent">مسلط</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">سطح گفتگو</label>
            <select name="languages[0][speaking]" class="w-full border border-gray-300 rounded p-2">
              <option value="basic">پایه</option>
              <option value="intermediate">متوسط</option>
              <option value="advanced">پیشرفته</option>
              <option value="fluent">مسلط</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">مدرک زبان (در صورت وجود)</label>
            <input type="file" name="languages[0][certificate]" class="w-full border border-gray-300 rounded p-2">
          </div>
        </div>
      </div>
    </div>
    
    <button type="button" id="add_language_btn" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
      <i class="fas fa-plus ml-1"></i> افزودن زبان جدید
    </button>
  </div>

  <!-- دکمه ثبت -->
  <div class="text-center pt-6">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-md font-medium">
      ذخیره اطلاعات
    </button>
  </div>
</form>

<!-- Templates for Dynamic Sections -->
<template id="course_template">
  <div class="course-item border border-gray-200 rounded-lg p-4 mb-4">
    <div class="flex justify-between items-center mb-2">
      <h3 class="text-sm font-medium text-gray-700">دوره جدید</h3>
      <button type="button" class="remove-item-btn text-red-500 hover:text-red-700">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">عنوان دوره</label>
        <input type="text" name="courses[{{index}}][title]" class="w-full border border-gray-300 rounded p-2">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">سطح مهارت</label>
        <select name="courses[{{index}}][level]" class="w-full border border-gray-300 rounded p-2">
          <option value="beginner">مقدماتی</option>
          <option value="intermediate">متوسط</option>
          <option value="advanced">پیشرفته</option>
          <option value="expert">تخصصی</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">موسسه برگزارکننده</label>
        <input type="text" name="courses[{{index}}][institution]" class="w-full border border-gray-300 rounded p-2">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">سال گذراندن</label>
        <input type="number" name="courses[{{index}}][year]" min="1300" max="1405" class="w-full border border-gray-300 rounded p-2">
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">مدرک دوره</label>
        <input type="file" name="courses[{{index}}][certificate]" class="w-full border border-gray-300 rounded p-2">
      </div>
    </div>
  </div>
</template>

<template id="achievement_template">
  <div class="achievement-item border border-gray-200 rounded-lg p-4 mb-4">
    <div class="flex justify-between items-center mb-2">
      <h3 class="text-sm font-medium text-gray-700">افتخار/گواهینامه جدید</h3>
      <button type="button" class="remove-item-btn text-red-500 hover:text-red-700">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">عنوان افتخار/گواهینامه</label>
        <input type="text" name="achievements[{{index}}][title]" class="w-full border border-gray-300 rounded p-2">
      </div>
      <div>
      <select name="achievements[{{index}}][level]" class="w-full border border-gray-300 rounded p-2">
          <option value="local">محلی</option>
          <option value="provincial">استانی</option>
          <option value="national">ملی</option>
          <option value="international">بین‌المللی</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">سال دریافت</label>
        <input type="number" name="achievements[{{index}}][year]" min="1300" max="1405" class="w-full border border-gray-300 rounded p-2">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مرجع اعطاکننده</label>
        <input type="text" name="achievements[{{index}}][issuer]" class="w-full border border-gray-300 rounded p-2">
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">مدرک/تصویر گواهینامه</label>
        <input type="file" name="achievements[{{index}}][document]" class="w-full border border-gray-300 rounded p-2">
      </div>
    </div>
  </div>
</template>

<template id="language_template">
  <div class="language-item border border-gray-200 rounded-lg p-4 mb-4">
    <div class="flex justify-between items-center mb-2">
      <h3 class="text-sm font-medium text-gray-700">زبان جدید</h3>
      <button type="button" class="remove-item-btn text-red-500 hover:text-red-700">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">زبان</label>
        <select name="languages[{{index}}][name]" class="w-full border border-gray-300 rounded p-2">
          <option value="english">انگلیسی</option>
          <option value="french">فرانسوی</option>
          <option value="german">آلمانی</option>
          <option value="spanish">اسپانیایی</option>
          <option value="arabic">عربی</option>
          <option value="chinese">چینی</option>
          <option value="russian">روسی</option>
          <option value="other">سایر</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">سطح خواندن</label>
        <select name="languages[{{index}}][reading]" class="w-full border border-gray-300 rounded p-2">
          <option value="basic">پایه</option>
          <option value="intermediate">متوسط</option>
          <option value="advanced">پیشرفته</option>
          <option value="fluent">مسلط</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">سطح گفتگو</label>
        <select name="languages[{{index}}][speaking]" class="w-full border border-gray-300 rounded p-2">
          <option value="basic">پایه</option>
          <option value="intermediate">متوسط</option>
          <option value="advanced">پیشرفته</option>
          <option value="fluent">مسلط</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">مدرک زبان (در صورت وجود)</label>
        <input type="file" name="languages[{{index}}][certificate]" class="w-full border border-gray-300 rounded p-2">
      </div>
    </div>
  </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Show education details when education level is selected (except illiterate)
  const educationLevelInputs = document.querySelectorAll('input[name="education_level"]');
  const educationDetails = document.getElementById('education_details');
  
  educationLevelInputs.forEach(input => {
    input.addEventListener('change', function() {
      educationDetails.classList.toggle('hidden', this.value === 'illiterate');
    });
  });

  // File upload preview for education documents
  const educationDocsInput = document.getElementById('education_documents');
  const educationDocsPreview = document.getElementById('education_docs_preview');
  
  educationDocsInput.addEventListener('change', function() {
    educationDocsPreview.innerHTML = '';
    
    Array.from(this.files).forEach(file => {
      const filePreview = document.createElement('div');
      filePreview.className = 'flex items-center justify-between bg-gray-50 p-2 rounded';
      
      filePreview.innerHTML = `
        <div class="flex items-center gap-2">
          <i class="fas ${getFileIcon(file.type)} text-gray-500"></i>
          <span class="text-sm truncate max-w-xs">${file.name}</span>
          <span class="text-xs text-gray-500">(${(file.size / 1024 / 1024).toFixed(2)}MB)</span>
        </div>
        <button type="button" class="remove-file-btn text-red-500 hover:text-red-700 text-sm">
          <i class="fas fa-times"></i>
        </button>
      `;
      
      filePreview.querySelector('.remove-file-btn').addEventListener('click', function() {
        // Remove the file from the input
        const dt = new DataTransfer();
        Array.from(educationDocsInput.files).forEach(f => {
          if (f !== file) dt.items.add(f);
        });
        educationDocsInput.files = dt.files;
        
        // Remove the preview
        filePreview.remove();
      });
      
      educationDocsPreview.appendChild(filePreview);
    });
  });

  // Dynamic course addition
  const addCourseBtn = document.getElementById('add_course_btn');
  const coursesContainer = document.getElementById('courses_container');
  const courseTemplate = document.getElementById('course_template');
  let courseIndex = 1;
  
  addCourseBtn.addEventListener('click', function() {
    const courseClone = courseTemplate.content.cloneNode(true);
    const courseHtml = courseClone.textContent.replace(/{{index}}/g, courseIndex);
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = courseHtml;
    
    const newCourse = tempDiv.firstChild;
    newCourse.querySelector('.remove-item-btn').addEventListener('click', function() {
      newCourse.remove();
    });
    
    coursesContainer.appendChild(newCourse);
    courseIndex++;
  });

  // Dynamic achievement addition
  const addAchievementBtn = document.getElementById('add_achievement_btn');
  const achievementsContainer = document.getElementById('achievements_container');
  const achievementTemplate = document.getElementById('achievement_template');
  let achievementIndex = 1;
  
  addAchievementBtn.addEventListener('click', function() {
    const achievementClone = achievementTemplate.content.cloneNode(true);
    const achievementHtml = achievementClone.textContent.replace(/{{index}}/g, achievementIndex);
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = achievementHtml;
    
    const newAchievement = tempDiv.firstChild;
    newAchievement.querySelector('.remove-item-btn').addEventListener('click', function() {
      newAchievement.remove();
    });
    
    achievementsContainer.appendChild(newAchievement);
    achievementIndex++;
  });

  // Dynamic language addition
  const addLanguageBtn = document.getElementById('add_language_btn');
  const languagesContainer = document.getElementById('languages_container');
  const languageTemplate = document.getElementById('language_template');
  let languageIndex = 1;
  
  addLanguageBtn.addEventListener('click', function() {
    const languageClone = languageTemplate.content.cloneNode(true);
    const languageHtml = languageClone.textContent.replace(/{{index}}/g, languageIndex);
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = languageHtml;
    
    const newLanguage = tempDiv.firstChild;
    newLanguage.querySelector('.remove-item-btn').addEventListener('click', function() {
      newLanguage.remove();
    });
    
    languagesContainer.appendChild(newLanguage);
    languageIndex++;
  });

  // Helper function to get file icon based on type
  function getFileIcon(fileType) {
    if (fileType.includes('pdf')) return 'fa-file-pdf';
    if (fileType.includes('image')) return 'fa-file-image';
    if (fileType.includes('word')) return 'fa-file-word';
    return 'fa-file-alt';
  }
});
</script>