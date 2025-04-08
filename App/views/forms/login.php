<h2 class="text-center text-2xl font-bold mb-6 text-gray-700">Login</h2>

<form method="post" action="#" class="space-y-4">
    
    <!-- Username or Email -->
    <div>
        <label for="usernameOrEmail" class="block text-gray-700 font-medium">Username or Email *</label>
        <input 
            type="text"
            name="usernameOrEmail"
            id="usernameOrEmail"
            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
            required
        >
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-gray-700 font-medium">Password *</label>
        <input 
            type="password"
            name="password"
            id="password"
            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
            required
        >
    </div>

    <!-- Login Button -->
    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
        Login
    </button>
</form>

<!-- Register Link -->
<p class="mt-4 text-center text-gray-600">
    Don't have an account? 
    <a href="<?php echo route('home.register') ?>" class="text-blue-500 hover:underline">Register here</a>.
</p>