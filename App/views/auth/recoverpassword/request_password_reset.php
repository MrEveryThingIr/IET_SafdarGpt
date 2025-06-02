  <!-- Flash Messages -->
  <div class="space-y-2">
    <?php isset($_SESSION['error']) ? errorMessage() : '' ?>
    <?php isset($_SESSION['success']) ? errorMessage() : '' ?>
  </div>


<section class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-12">
    <form action="<?= route('recoverpassword.request'); ?>" 
          method="POST"
          class="w-full max-w-md p-8 bg-white rounded-lg shadow-md space-y-6">

        <h2 class="text-2xl font-semibold text-gray-800 text-center">Password Recovery</h2>

        <?= csrf('field') ?>

        <div>
            <label for="to" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
            </label>
            <input type="email" 
                   name="to" 
                   id="to" 
                   required 
                   autofocus
                   placeholder="Enter your registered email"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Send Recovery Link
        </button>

        <div class="text-sm text-center">
            <a href="<?= route('auth.login') ?>" class="text-blue-600 hover:underline">Back to login</a>
        </div>
    </form>
</section>
