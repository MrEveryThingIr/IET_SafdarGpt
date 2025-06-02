  <!-- Flash Messages -->
  <div class="space-y-2">
    <?php isset($_SESSION['error']) ? errorMessage() : '' ?>
    <?php isset($_SESSION['success']) ? errorMessage() : '' ?>
  </div>
  
  <form method="POST" action="<?= htmlspecialchars(route('auth.register'), ENT_QUOTES, 'UTF-8') ?>" enctype="multipart/form-data" class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow-md">
    <?= csrf('field') ?>
    <h1 class="text-2xl font-bold mb-4">Register</h1>
    
    <?= inputField('firstname', 'First Name', 'text', ['required' => true]) ?>
    <?= inputField('lastname', 'Last Name', 'text', ['required' => true]) ?>
    <?= inputField('username', 'Username', 'text', ['required' => true]) ?>
    <?= inputField('email', 'Email', 'email', ['required' => true]) ?>
    <?= inputField('password', 'Password', 'password', ['required' => true, 'minlength' => 8]) ?>
    <?= inputField('phone', 'Phone', 'tel') ?>
    <?= inputField('birthdate', 'Birthdate', 'date') ?>
    
    <select name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        <option value="">Select Role</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    
    <?= inputField('main_job', 'Main Job') ?>
    
    <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        <option value="">Select Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>
    
    <div class="mt-4">
        <label class="block font-medium">Profile Image</label>
        <input type="file" name="img" accept="image/*" class="mt-1 block w-full">
    </div>
    
    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Register</button>

    <p class="mt-4 text-sm text-gray-600">
        Already have an account?
        <a href="<?= htmlspecialchars(route('auth.login'), ENT_QUOTES, 'UTF-8') ?>" class="text-blue-600 hover:underline">Login here</a>
    </p>
</form>