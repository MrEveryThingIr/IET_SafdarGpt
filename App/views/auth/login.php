<form method="POST" action="<?= htmlspecialchars(route('auth.login.post'), ENT_QUOTES, 'UTF-8') ?>" 
      class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg border border-gray-100">
    <?= csrf('field') ?>
    
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
        <p class="text-gray-500 mt-2">Sign in to your account</p>
    </div>

    <div class="space-y-6">
        <?= inputField('email', 'Email or Username', 'text', [
            'required' => true,
            'autocomplete' => 'username',
            'class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition',
            'placeholder' => 'you@example.com'
        ]) ?>
        
        <div class="relative">
            <?= inputField('password', 'Password', 'password', [
                'required' => true,
                'autocomplete' => 'current-password',
                'minlength' => 8,
                'class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition',
                'placeholder' => '••••••••'
            ]) ?>
            
            <div class="flex justify-end mt-2">
                <a href="<?= htmlspecialchars(route('auth.email.send_recoverpass_email_form'), ENT_QUOTES, 'UTF-8') ?>" 
                   class="text-sm text-green-600 hover:text-green-700 hover:underline transition-colors">
                    Forgot Password?
                </a>
            </div>
        </div>

        <button type="submit" 
                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
            Continue
        </button>
    </div>

    <div class="mt-6 text-center">
        <p class="text-gray-500">
            Don't have an account?
            <a href="<?= htmlspecialchars(route('auth.register'), ENT_QUOTES, 'UTF-8') ?>" 
               class="text-green-600 hover:text-green-700 font-medium hover:underline transition-colors">
                Create account
            </a>
        </p>
    </div>
</form>