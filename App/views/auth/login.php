<h1 class="text-2xl font-bold mb-4">Login</h1>
<form method="POST" action="<?= route('auth.login.post') ?>" class="space-y-4">
    <?= inputField('email', 'Email or Username') ?>
    <?= inputField('password', 'Password', 'password') ?>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Login</button>
    
    <p class="text-sm text-gray-600">
        Don't have an account?
        <a href="<?= route('auth.register') ?>" class="text-green-600 hover:underline">Register here</a>
    </p>
</form>
