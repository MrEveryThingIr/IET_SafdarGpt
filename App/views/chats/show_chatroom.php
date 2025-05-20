<!-- Chatroom Show Page -->
<div class="container mx-auto px-4 py-8 space-y-6 max-w-6xl">
  <!-- Flash Messages -->
  <div class="space-y-2">
    <?php isset($_SESSION['error']) ? errorMessage() : '' ?>
    <?php isset($_SESSION['success']) ? errorMessage() : '' ?>
  </div>

  <!-- 🏷️ Chatroom Details -->
  <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 border border-gray-100">
    <div class="flex items-center mb-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
      </svg>
      <h2 class="text-2xl font-bold text-gray-800">اطلاعات اتاق گفتگو</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="space-y-2">
        <p class="text-gray-600"><span class="font-medium text-gray-800">عنوان:</span> <?php echo $room['title'] ?></p>
        <p class="text-gray-600"><span class="font-medium text-gray-800">دسته‌بندی:</span> 
          <?php foreach($categories as $category): ?>
            <?php echo ($category['id']===$room['category_id']) ? $category['cate_name'] : '' ?>
          <?php endforeach ?>
        </p>
      </div>
      <div class="space-y-2">
        <p class="text-gray-600"><span class="font-medium text-gray-800">توضیحات:</span> <?php echo $room['description'] ?></p>
        <p class="text-gray-500 text-sm"><span class="font-medium text-gray-600">تاریخ ایجاد:</span> <?php echo $room['created_at'] ?></p>
      </div>
    </div>
  </div>

  <!-- 🙋 Invite Member Form -->
  <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-md overflow-hidden border border-blue-100">
    <div class="p-6">
      <div class="flex items-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-800">دعوت کاربر جدید</h3>
      </div>
      
      <form action="<?php echo route('ietchats.room.invite') ?>" method="POST" class="space-y-4" dir="rtl">
        <?php echo csrf('field') ?>
        <input type="hidden" name="to_chatroom_id" value="<?php echo $room['id'] ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label for="invited_user_id" class="block text-sm font-medium text-gray-700 mb-1">انتخاب کاربر</label>
            <select name="invited_user_id" id="invited_user_id" class="block w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <?php foreach($all_users as $user): ?>
                <option value="<?php echo $user['id'] ?>"><?php echo $user['username'] ?></option>
              <?php endforeach ?>
            </select>
          </div>

          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان دعوت</label>
            <input type="text" name="title" id="title" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          </div>

          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
            <input type="text" name="description" id="description" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          </div>
        </div>

        <div class="flex justify-start">
          <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
            </svg>
            ارسال دعوت
          </button>
        </div>
      </form>
    </div>
  </div>



  <!-- 📜 All Chats -->
  <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="p-6">
      <div class="flex items-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-800">تاریخچه گفتگوها</h3>
      </div>
      
      <div class="space-y-4 max-h-[500px] overflow-y-auto px-2 py-4">
        <?php if(!empty($chats)): ?>
          <?php foreach($chats as $chat): ?>
            <?php if($chat['sender_id'] === user()['id']): ?>
              <!-- Sent by current user -->
              <div class="flex justify-end">
                <div class="max-w-md bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl rounded-tr-none px-5 py-3 shadow-md">
                  <div class="flex justify-between items-center mb-1">
                    
                       <!-- User Info Section -->
                <div class="flex items-center gap-3 mb-4">
                  <img src="<?php echo user()['img'] ?>" alt="User avatar" class="w-10 h-10 rounded-full object-cover border-2 border-blue-100">
                  <a href="<?= route('user.profile', ['user_id' => $chat['sender_id'], 'feature' => 'identification']) ?>" class="font-medium text-yellow-100 hover:text-blue-800">
                    <?php echo user()['username'] ?>
                  </a>
                </div>
                    <span class="text-xs opacity-80"><?php echo $chat['created_at'] ?></span>
                  </div>
                  <p class="text-white"><?php echo $chat['chat_context'] ?></p>
                </div>
              </div>
            <?php else: ?>
              <!-- Sent by others -->
              <div class="flex justify-start">
                <div class="max-w-md bg-gray-100 rounded-2xl rounded-tl-none px-5 py-3 shadow-md">
                  <div class="flex justify-between items-center mb-1">
                   

                       <!-- User Info Section -->
          <div class="flex items-center gap-3 mb-4">
            <img src="<?php echo user($chat['sender_id'])['img'] ?>" alt="User avatar" class="w-10 h-10 rounded-full object-cover border-2 border-blue-100">
            <a href="<?= route('user.profile', ['user_id' => $chat['sender_id'], 'feature' => 'identification']) ?>" class="font-medium text-blue-600 hover:text-blue-800">
              <?php echo user($chat['sender_id'])['username'] ?>
            </a>
          </div>

                    <span class="text-xs text-gray-500"><?php echo $chat['created_at'] ?></span>
                  </div>
                  <p class="text-gray-800"><?php echo $chat['chat_context'] ?></p>
                </div>
              </div>
            <?php endif ?>
          <?php endforeach ?>
        <?php else: ?>
          <div class="text-center py-8 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p>هنوز گفتگویی در این اتاق انجام نشده است</p>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>

  <!-- 💬 Chat Form -->
  <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="p-6">
      <div class="flex items-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <h3 class="text-xl font-semibold text-gray-800">ارسال پیام جدید</h3>
      </div>
      
      <form action="<?php echo route('ietchats.send_message') ?>" method="POST" class="space-y-4" dir="rtl">
        <?php echo csrf('field') ?>
        <input type="hidden" name="to_chatroom_id" value="<?php echo $room['id'] ?>">
        
        <div>
          <label for="key_words" class="block text-sm font-medium text-gray-700 mb-1">کلمات کلیدی (اختیاری)</label>
          <input type="text" name="key_words" id="key_words" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
          <label for="chat_context" class="block text-sm font-medium text-gray-700 mb-1">متن پیام</label>
          <textarea name="chat_context" id="chat_context" rows="4" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required></textarea>
        </div>

        <div class="flex justify-start">
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
            </svg>
            ارسال پیام
          </button>
        </div>
      </form>
    </div>
  </div>

</div>