<!-- TailwindCSS Form for User Registration -->
<h2 class="text-center text-2xl font-bold mb-6">Create an Account</h2>

<div class="flex justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <form action="#" method="post" class="space-y-4" enctype="multipart/form-data">
            
            <!-- First Name -->
            <div>
                <label for="firstname" class="block text-gray-700 font-medium">First Name *</label>
                <input 
                    type="text" 
                    name="firstname" 
                    id="firstname" 
                    placeholder="Enter your first name" 
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                    required>
            </div>

            <!-- Last Name -->
            <div>
                <label for="lastname" class="block text-gray-700 font-medium">Last Name *</label>
                <input 
                    type="text" 
                    name="lastname" 
                    id="lastname" 
                    placeholder="Enter your last name" 
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                    required>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-gray-700 font-medium">Phone (Optional)</label>
                <input 
                    type="text" 
                    name="phone" 
                    id="phone" 
                    placeholder="Enter your phone number"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium">Email Address *</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Enter your email"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                    required>
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-gray-700 font-medium">Username *</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    placeholder="Choose a unique username"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                    required>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-gray-700 font-medium">Role *</label>
                <select name="role" id="role" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="editor">Editor</option>
                </select>
            </div>

            <!-- Main Job -->
            <div>
                <label for="main_job" class="block text-gray-700 font-medium">Main Job (Optional)</label>
                <input 
                    type="text" 
                    name="main_job" 
                    id="main_job" 
                    placeholder="Enter your main job"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
            </div>

            <!-- Birthdate -->
            <div>
                <label for="birthdate" class="block text-gray-700 font-medium">Birthdate *</label>
                <input 
                    type="date" 
                    name="birthdate" 
                    id="birthdate"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                    required>
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-gray-700 font-medium">Gender *</label>
                <div class="mt-1 flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="male" class="text-blue-500" required>
                        <span class="ml-2">Male</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="female" class="text-blue-500" required>
                        <span class="ml-2">Female</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="other" class="text-blue-500" required>
                        <span class="ml-2">Other</span>
                    </label>
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="img" class="block text-gray-700 font-medium">Profile Image (Optional)</label>
                <input 
                    type="file" 
                    name="img" 
                    id="img" 
                    accept="image/*" 
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                <small class="text-gray-500">Accepted formats: JPEG, PNG, GIF. Max size: 2MB.</small>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-medium">Password *</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Choose a strong password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                    required>
                <small class="text-gray-500">Must be at least 8 characters long.</small>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirm_password" class="block text-gray-700 font-medium">Confirm Password *</label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    id="confirm_password" 
                    placeholder="Re-enter your password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                    required>
                <div id="passwordMismatch" class="text-red-500 text-sm mt-1 hidden">
                    Passwords do not match.
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Register
            </button>

        </form>

        <!-- Login Link -->
        <p class="mt-4 text-center text-gray-600">
            Already have an account? 
            <a href="<?php echo route('home.login')?>" class="text-blue-500 hover:underline">Login here</a>.
        </p>
    </div>
</div>

<!-- Password Match Validation Script -->
<script>
    document.getElementById('confirm_password').addEventListener('input', function() {
        let password = document.getElementById('password').value;
        let confirmPassword = this.value;
        let errorDiv = document.getElementById('passwordMismatch');

        if (password !== confirmPassword) {
            errorDiv.classList.remove('hidden');
        } else {
            errorDiv.classList.add('hidden');
        }
    });
</script>