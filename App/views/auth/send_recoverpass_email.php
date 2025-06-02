<form action="<?php echo route('auth.recoverpass.send_email'); ?>" 
      method="POST"
      class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
      
      <?= csrf('field') ?>
 
    <div class="mb-4">
        <label for="to" class="block text-sm font-medium text-gray-700 mb-1">
            Email Address
        </label>
        <input type="email" 
               name="to" 
               id="to" 
               required
               placeholder="Enter your registered email"
               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
    </div>

    <button type="submit" 
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
        Send Recovery Link
    </button>
</form>