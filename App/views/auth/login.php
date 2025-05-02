
<form method="POST" action="<?= route('auth.login.post') ?>" class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow-md">
<h1 class="text-2xl font-bold mb-4">Login</h1>
    <?= inputField('email', 'Email or Username') ?>
    <?= inputField('password', 'Password', 'password') ?>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded m-2">Login</button>
    
    <p class="text-sm text-gray-600">
        Don't have an account?
        <a href="<?= route('auth.register') ?>" class="text-green-600 hover:underline">Register here</a>
    </p>
</form>
