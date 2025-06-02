  <!-- Flash Messages -->
  <div class="space-y-2">
    <?php isset($_SESSION['error']) ? errorMessage() : '' ?>
    <?php isset($_SESSION['success']) ? errorMessage() : '' ?>
  </div>

<section class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-12">
    <form action="<?= route('auth.change_password.submit'); ?>" 
          method="POST"
          class="w-full max-w-md p-8 bg-white rounded-lg shadow-md space-y-6">

        <h2 class="text-2xl font-semibold text-gray-800 text-center">Change Password</h2>

        <?= csrf('field') ?>

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
            <input type="password"
                   name="current_password"
                   id="current_password"
                   required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
            <input type="password"
                   name="password"
                   id="password"
                   required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
        </div>

        <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
            <input type="password"
                   name="confirm_password"
                   id="confirm_password"
                   required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
        </div>

        <button type="submit"
                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition">
            Update Password
        </button>
    </form>
</section>
