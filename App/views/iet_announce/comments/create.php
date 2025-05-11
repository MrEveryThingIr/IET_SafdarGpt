<form action="<?php echo route('ietannounce.store_comment', ['announce_id' => $announce_id]) ?>" 
      method="post" 
      class="grid grid-cols-1 gap-6 w-full max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md"
      id="commentForm">

  

    <div class="space-y-2">
        <label for="comment_on_announce" class="block text-sm font-medium text-gray-700">
            متن دیدگاه/پیشنهاد
        </label>
        <textarea name="comment_on_announce" 
                  id="comment_on_announce" 
                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-300 focus:border-green-500"
                  rows="8"
                  required
                  minlength="20"
                  placeholder="پیشنهاد خود را با جزئیات وارد نمایید..."><?php 
            echo htmlspecialchars(
            'اینجا درواقع یک فضای شبیه به مزایده یا مناقصه (بسته به شرایط مختلف) میباشد که شما میتوانید نسبت به ویژگی های اعلام مورد نظر پیشنهادات خود را وارد نمایید. مثلا اگر قیمت ابتدایی پیشنهاد شده برای شما مقدور نیست پیشنهاد خودرا ارائه دهید تا توسط اعلام کننده مورد بررسی قرار گیرد. همچنین شما میتوانید پیشنهاد پرداخت نسبی بدهید. 

نمونه هایی از پیشنهاد پرداخت نسبی:
• نصف نقد، نصف کالا
• 70% پرداخت نقدی، و تکمیل پرداخت با ارائه خدمات
• 20% کالای نوع اول + 30% کالای نوع دوم + 50% خدمات
• ارائه خدمات و کالا در ازای کل مبلغ

توجه: وبسایت ما بعنوان مرکز تبادل عمل میکند و در صورت نیاز میتواند بعنوان واسطه غیرمستقیم عمل نماید.'
            )
        ?></textarea>
        <p class="text-xs text-gray-500">حداقل ۲۰ کاراکتر نیاز است</p>
    </div>

    <button type="submit" 
            class="mt-4 w-full bg-green-600 text-white px-5 py-3 rounded-md hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
        ارسال دیدگاه
    </button>
</form>

<script>
document.getElementById('commentForm').addEventListener('submit', function(e) {
    const textarea = document.getElementById('comment_on_announce');
    if(textarea.value.trim().length < 20) {
        e.preventDefault();
        alert('لطفاً حداقل ۲۰ کاراکتر برای دیدگاه وارد نمایید');
        textarea.focus();
    }
});
</script>