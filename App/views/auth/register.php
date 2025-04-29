<h1 class="text-2xl font-bold mb-4">Register</h1>
<form method="POST" action="<?= route('auth.register') ?>" enctype="multipart/form-data" class="center space-y-4">
    <?= inputField('firstname', 'First Name') ?>
    <?= inputField('lastname', 'Last Name') ?>
    <?= inputField('username', 'Username') ?>
    <?= inputField('email', 'Email', 'email') ?>
    <?= inputField('password', 'Password', 'password') ?>
    <?= inputField('phone', 'Phone', 'text') ?>
    <?= inputField('birthdate', 'Birthdate', 'date') ?>
    <?= inputField('role', 'Role') ?>
    <?= inputField('main_job', 'Main Job') ?>
    <?= inputField('gender', 'Gender') ?>
    
    <div>
        <label class="block font-medium">Profile Image</label>
        <input type="file" name="img" class="mt-1 block w-full">
    </div>
    
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Register</button>

    <p class="text-sm text-gray-600">
        Already have an account?
        <a href="<?= route('auth.login') ?>" class="text-blue-600 hover:underline">Login here</a>
    </p>
</form>
