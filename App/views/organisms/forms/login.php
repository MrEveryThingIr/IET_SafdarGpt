<?php $errors = $_SESSION['errors'] ?? []; ?>
<?php $errorMsg = $errors['auth'][0] ?? flash('error'); ?>

<h2 class="text-center text-2xl font-bold mb-6 text-gray-700">Login</h2>

<?php if ($errorMsg): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4"><?= $errorMsg ?></div>
<?php endif; ?>

<form method="post" action="<?= route('user.login') ?>" class="space-y-4">
    <?= inputField('usernameOrEmail', 'Username or Email *') ?>
    <?= inputField('password', 'Password *', 'password') ?>

    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
        Login
    </button>
</form>

<p class="mt-4 text-center text-gray-600">
    Don't have an account? 
    <a href="<?= route('home.register') ?>" class="text-blue-500 hover:underline">Register here</a>.
</p>

<?php unset($_SESSION['errors']); ?>
