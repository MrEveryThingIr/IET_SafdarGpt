<form method="POST" action="<?= htmlspecialchars(route('auth.login.post'), ENT_QUOTES, 'UTF-8') ?>" class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow-md">
    <?= csrf('field') ?>
    <h1 class="text-2xl font-bold mb-4">Login</h1>
    
    <?= inputField('email', 'Email or Username', 'text', [
        'required' => true,
        'autocomplete' => 'username'
    ]) ?>
    
    <?= inputField('password', 'Password', 'password', [
        'required' => true,
        'autocomplete' => 'current-password',
        'minlength' => 1
    ]) ?>
    
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded m-2 hover:bg-green-700 transition-colors">
        Login
    </button>
    
    <p class="text-sm text-gray-600 mt-4">
        Don't have an account?
        <a href="<?= htmlspecialchars(route('auth.register'), ENT_QUOTES, 'UTF-8') ?>" class="text-green-600 hover:underline">
            Register here
        </a>
    </p>
</form>