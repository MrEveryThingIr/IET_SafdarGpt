
<div class="article-container bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
  <!-- Article Status Bar -->
  <div class="status-bar flex justify-between items-center mb-6 p-3 bg-gray-50 rounded-lg">
    <div class="flex items-center space-x-2 space-x-reverse">
      <span class="text-sm font-medium text-gray-700">وضعیت:</span>
      <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">منتشر شده</span>
    </div>
    <div class="text-sm text-gray-500">زمان مطالعه: 5 دقیقه</div>
  </div>

  <!-- Article Title -->
  <h1 class="article-title text-3xl font-bold text-gray-800 mb-6 text-center border-b pb-4">
    عنوان مقاله نمونه
  </h1>

  <!-- Content Placeholder -->
  <div class="content-placeholder min-h-[300px] border-2 border-dashed border-gray-300 rounded-lg p-6 mb-8 bg-gray-50">
    <p class="text-center text-gray-500 mb-4">محتوای مقاله شما اینجا نمایش داده خواهد شد</p>
    
    <!-- Block Insertion Menu -->
    <div class="block-menu grid grid-cols-2 md:grid-cols-4 gap-3">
      <!-- Basic Blocks -->
      <div class="menu-category">
        <h3 class="category-title text-xs font-semibold text-gray-500 mb-2">بلوک های پایه</h3>
        <div class="space-y-2">
          <button class="block-option w-full text-right px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm flex items-center justify-end" data-type="paragraph">
            <span>پاراگراف</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5h7m-7 7h7m-7 7h7M4 5h7m-7 7h7m-7 7h7"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm flex items-center justify-end" data-type="heading">
            <span>عنوان</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-sm flex items-center justify-end" data-type="image">
            <span>تصویر</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Text Formatting -->
      <div class="menu-category">
        <h3 class="category-title text-xs font-semibold text-gray-500 mb-2">قالب بندی متن</h3>
        <div class="space-y-2">
          <button class="block-option w-full text-right px-3 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg text-sm flex items-center justify-end" data-type="list">
            <span>لیست</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg text-sm flex items-center justify-end" data-type="quote">
            <span>نقل قول</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg text-sm flex items-center justify-end" data-type="divider">
            <span>جداکننده</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Media -->
      <div class="menu-category">
        <h3 class="category-title text-xs font-semibold text-gray-500 mb-2">رسانه</h3>
        <div class="space-y-2">
          <button class="block-option w-full text-right px-3 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-sm flex items-center justify-end" data-type="video">
            <span>ویدیو</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-sm flex items-center justify-end" data-type="audio">
            <span>صوت</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-sm flex items-center justify-end" data-type="embed">
            <span>محتوای嵌入</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Advanced -->
      <div class="menu-category">
        <h3 class="category-title text-xs font-semibold text-gray-500 mb-2">پیشرفته</h3>
        <div class="space-y-2">
          <button class="block-option w-full text-right px-3 py-2 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg text-sm flex items-center justify-end" data-type="cta">
            <span>دعوت به اقدام</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg text-sm flex items-center justify-end" data-type="faq">
            <span>پرسش و پاسخ</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </button>
          <button class="block-option w-full text-right px-3 py-2 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg text-sm flex items-center justify-end" data-type="custom_html">
            <span>HTML سفارشی</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Sample Content Preview -->
  <div class="content-preview hidden">
    <!-- Content Preview -->
<div class="content-preview max-w-4xl mx-auto px-4 py-8 bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Article Header -->
    <div class="article-header mb-8 text-center border-b pb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2" id="preview-title">عنوان مقاله</h1>
        <div class="flex justify-center items-center gap-4 text-sm text-gray-600">
            <span class="flex items-center">
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span id="preview-read-time">5 دقیقه</span>
            </span>
            <span>•</span>
            <span id="preview-status" class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">منتشر شده</span>
        </div>
    </div>

    <!-- Blocks Container -->
    <div class="blocks-container space-y-8" dir="rtl">
        <!-- Blocks will be dynamically inserted here -->
        
        <!-- Template for each block type (hidden by default) -->
        
        <!-- Paragraph Block -->
        <div class="block-template paragraph-block hidden">
            <div class="text-gray-700 leading-relaxed text-justify" data-content></div>
        </div>
        
        <!-- Heading Block -->
        <div class="block-template heading-block hidden">
            <h2 class="font-bold text-gray-800 mt-8 mb-4" data-heading-level data-content></h2>
        </div>
        
        <!-- Image Block -->
        <div class="block-template image-block hidden">
            <div class="my-6">
                <img data-image-url class="w-full rounded-lg shadow-md" data-image-alt>
                <p class="mt-2 text-sm text-gray-500 text-center" data-image-caption></p>
            </div>
        </div>
        
        <!-- Video Block -->
        <div class="block-template video-block hidden">
            <div class="my-6">
                <div class="aspect-w-16 aspect-h-9">
                    <iframe data-content class="w-full h-96 rounded-lg shadow-md" frameborder="0" allowfullscreen></iframe>
                </div>
                <p class="mt-2 text-sm text-gray-500 text-center" data-image-caption></p>
            </div>
        </div>
        
        <!-- Audio Block -->
        <div class="block-template audio-block hidden">
            <div class="my-6">
                <audio controls class="w-full rounded-lg" data-content>
                    Your browser does not support the audio element.
                </audio>
                <p class="mt-2 text-sm text-gray-500 text-center" data-image-caption></p>
            </div>
        </div>
        
        <!-- List Block -->
        <div class="block-template list-block hidden">
            <ul class="space-y-2 text-gray-700 my-4" data-list-type data-content></ul>
        </div>
        
        <!-- Quote Block -->
        <div class="block-template quote-block hidden">
            <div class="my-8 p-6 bg-gray-50 border-r-4 border-blue-500 rounded">
                <blockquote class="italic text-gray-700 text-lg" data-content></blockquote>
                <p class="mt-2 text-gray-600 font-medium" data-image-caption></p>
            </div>
        </div>
        
        <!-- Embed Block -->
        <div class="block-template embed-block hidden">
            <div class="my-6">
                <div data-content class="embed-container"></div>
                <p class="mt-2 text-sm text-gray-500 text-center" data-image-caption></p>
            </div>
        </div>
        
        <!-- CTA Block -->
        <div class="block-template cta-block hidden">
            <div class="my-8 p-6 bg-blue-50 rounded-lg text-center">
                <p class="text-gray-700 mb-4 text-lg" data-content></p>
                <a data-cta-link class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition" data-cta-text></a>
            </div>
        </div>
        
        <!-- FAQ Block -->
        <div class="block-template faq-block hidden">
            <div class="my-8 space-y-4" data-content></div>
        </div>
        
        <!-- Divider Block -->
        <div class="block-template divider-block hidden">
            <hr class="my-8 border-gray-200">
        </div>
        
        <!-- Custom HTML Block -->
        <div class="block-template custom-html-block hidden">
            <div class="my-6" data-content></div>
        </div>
    </div>
</div>
  </div>
</div>

<script>
document.querySelectorAll('.block-option').forEach(button => {
  button.addEventListener('click', function() {
    const blockType = this.getAttribute('data-type');
    alert(`Adding new ${blockType} block...`);
    // In a real implementation, this would open a modal or form for the specific block type
  });
});


// Function to render blocks in preview
function renderBlocks(blocks) {
    const container = document.querySelector('.blocks-container');
    container.innerHTML = '';
    
    blocks.forEach(block => {
        const template = document.querySelector(`.${block.block_type}-block`).cloneNode(true);
        template.classList.remove('hidden', 'block-template');
        
        switch(block.block_type) {
            case 'paragraph':
                template.querySelector('[data-content]').textContent = block.content;
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'heading':
                const heading = template.querySelector('[data-content]');
                heading.textContent = block.content;
                heading.classList.add(`text-${7-block.heading_level}xl`);
                if(block.css_class) heading.classList.add(block.css_class);
                break;
                
            case 'image':
                const img = template.querySelector('img');
                img.src = block.image_url;
                img.alt = block.image_alt || '';
                template.querySelector('[data-image-caption]').textContent = block.image_caption || '';
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'video':
                const iframe = template.querySelector('iframe');
                iframe.src = block.content;
                template.querySelector('[data-image-caption]').textContent = block.image_caption || '';
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'audio':
                const audio = template.querySelector('audio');
                audio.src = block.content;
                template.querySelector('[data-image-caption]').textContent = block.image_caption || '';
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'list':
                const ul = template.querySelector('ul');
                ul.className = block.list_type === 'ordered' ? 'list-decimal pl-5' : 'list-disc pl-5';
                block.content.split('\n').forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item.trim();
                    ul.appendChild(li);
                });
                if(block.css_class) ul.classList.add(block.css_class);
                break;
                
            case 'quote':
                template.querySelector('blockquote').textContent = block.content;
                template.querySelector('[data-image-caption]').textContent = block.image_caption || '';
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'embed':
                template.querySelector('.embed-container').innerHTML = block.content;
                template.querySelector('[data-image-caption]').textContent = block.image_caption || '';
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'cta':
                template.querySelector('[data-content]').textContent = block.content;
                const ctaLink = template.querySelector('[data-cta-link]');
                const additionalData = block.additional_data ? JSON.parse(block.additional_data) : {};
                ctaLink.href = additionalData.cta_link || '#';
                ctaLink.textContent = additionalData.cta_text || 'کلیک کنید';
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'faq':
                const faqContainer = template.querySelector('[data-content]');
                try {
                    const faqs = JSON.parse(block.content);
                    faqs.forEach(faq => {
                        const faqItem = document.createElement('div');
                        faqItem.className = 'border-b border-gray-200 pb-4';
                        faqItem.innerHTML = `
                            <h3 class="font-bold text-gray-800 text-lg">${faq.question}</h3>
                            <p class="mt-1 text-gray-700">${faq.answer}</p>
                        `;
                        faqContainer.appendChild(faqItem);
                    });
                } catch(e) {
                    console.error('Invalid FAQ format', e);
                }
                if(block.css_class) template.classList.add(block.css_class);
                break;
                
            case 'divider':
                if(block.css_class) template.querySelector('hr').classList.add(block.css_class);
                break;
                
            case 'custom_html':
                template.querySelector('[data-content]').innerHTML = block.content;
                break;
        }
        
        container.appendChild(template);
    });
}

// Example usage with your data:
const articleData = <?= json_encode($article) ?>;
document.getElementById('preview-title').textContent = articleData.title;
document.getElementById('preview-read-time').textContent = `${articleData.time_to_read} دقیقه`;
document.getElementById('preview-status').textContent = articleData.status === 'published' ? 'منتشر شده' : 'پیش‌نویس';

if(articleData.blocks && articleData.blocks.length > 0) {
    renderBlocks(articleData.blocks);
} else {
    document.querySelector('.blocks-container').innerHTML = `
        <div class="text-center py-12 text-gray-500">
            <p>هنوز بلوکی به این مقاله اضافه نشده است.</p>
            <p class="mt-2">برای شروع، یکی از بلوک‌های بالا را انتخاب کنید.</p>
        </div>
    `;
}
</script>