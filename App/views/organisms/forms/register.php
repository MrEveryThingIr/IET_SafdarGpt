<?php $errors = $_SESSION['errors'] ?? []; ?>
<?php $success = flash('success'); ?>
<?php $globalError = $errors['system'][0] ?? null; ?>

<h2 class="text-center text-2xl font-bold mb-6 text-gray-700">Create an Account</h2>

<?php if ($success): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4"><?= $success ?></div>
<?php endif; ?>

<?php if ($globalError): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4"><?= $globalError ?></div>
<?php endif; ?>

<div class="flex justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <form action="<?= route('user.store') ?>" method="post" class="space-y-4" enctype="multipart/form-data">

            <?= inputField('firstname', 'First Name *') ?>
            <?= inputField('lastname', 'Last Name *') ?>
            <?= inputField('phone', 'Phone (Optional)') ?>
            <?= inputField('email', 'Email Address *', 'email') ?>
            <?= inputField('username', 'Username *') ?>
            <?= inputField('main_job', 'Main Job (Optional)') ?>
            <?= inputField('birthdate', 'Birthdate *', 'date') ?>
            <?= inputField('password', 'Password *', 'password') ?>
            <?= inputField('confirm_password', 'Confirm Password *', 'password') ?>

            <!-- Role -->
            <div>
                <label for="role" class="block text-gray-700 font-medium">Role *</label>
                <select name="role" id="role" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="editor">Editor</option>
                </select>
                <?php if (isset($errors['role'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['role'][0] ?></p>
                <?php endif; ?>
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-gray-700 font-medium">Gender *</label>
                <div class="mt-1 flex items-center space-x-4">
                    <?php foreach (['male', 'female', 'other'] as $g): ?>
                        <label class="inline-flex items-center">
                            <input type="radio" name="gender" value="<?= $g ?>" class="text-blue-500" required>
                            <span class="ml-2"><?= ucfirst($g) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <?php if (isset($errors['gender'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['gender'][0] ?></p>
                <?php endif; ?>
            </div>

            <!-- Profile Image -->
            <div>
                <label for="img" class="block text-gray-700 font-medium">Profile Image (Optional)</label>
                <input type="file" name="img" id="img" accept="image/*"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                <small class="text-gray-500">Accepted: JPEG, PNG, GIF. Max size: 2MB.</small>
                <?php if (isset($errors['img'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['img'][0] ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Register
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Already have an account? <a href="<?= route('home.login') ?>" class="text-blue-500 hover:underline">Login here</a>.
        </p>
    </div>
</div>

<?php unset($_SESSION['errors']); ?>
P