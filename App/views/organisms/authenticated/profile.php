<div class="flex flex-wrap p-6 bg-gray-100 min-h-screen">
    <!-- Left Column: Profile Information -->
    <div class="w-full md:w-1/3 p-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden p-8">
            <div class="text-center space-y-4">
                <img class="w-28 h-28 rounded-full mx-auto border-4 border-gray-200"
                     src="<?= uploads_url($user['img'] ?? 'dummy-profile.png') ?>"
                     alt="User profile picture">

                <h3 class="text-2xl font-semibold"><?= sanitize($user['firstname'] ?? '') ?></h3>
                <p class="text-gray-500"><?= sanitize($user['main_job'] ?? '') ?></p>
            </div>
            <ul class="mt-8 space-y-4 text-sm text-gray-700">
                <li class="flex justify-between border-b pb-3">
                    <span class="font-medium">Username</span><span><?= sanitize($user['username'] ?? '') ?></span>
                </li>
                <li class="flex justify-between border-b pb-3">
                    <span class="font-medium">Email</span><span><?= sanitize($user['email'] ?? '') ?></span>
                </li>
                <li class="flex justify-between border-b pb-3">
                    <span class="font-medium">Phone</span><span><?= sanitize($user['phone'] ?? '') ?></span>
                </li>
                <li class="flex justify-between border-b pb-3">
                    <span class="font-medium">Birthday</span><span><?= sanitize($user['birthdate'] ?? '') ?></span>
                </li>
                <li class="flex justify-between border-b pb-3">
                    <span class="font-medium">Organization</span><span>Example Corp</span>
                </li>
                <li class="flex justify-between">
                    <span class="font-medium">Location</span><span>New York, USA</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Column: Tabs -->
    <div class="w-full md:w-2/3 p-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b bg-gray-50 flex space-x-6 px-8 py-4 text-gray-600">
                <button class="py-3 px-5 hover:text-blue-500 focus:text-blue-600" onclick="toggleTab('timeline')">Timeline</button>
                <button class="py-3 px-5 text-blue-600 font-semibold" onclick="toggleTab('settings')">Settings</button>
                <button class="py-3 px-5 hover:text-blue-500 focus:text-blue-600" onclick="toggleTab('password')">Password</button>
            </div>

            <!-- Tab Content -->
            <div class="p-8 space-y-6">
                <!-- Timeline Tab -->
                <div id="timeline" class="hidden space-y-6">
                    <div class="flex items-start space-x-6">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-lg">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="space-y-3">
                            <p class="text-gray-600 text-sm">10 Feb. 2014 - 12:05</p>
                            <h3 class="font-semibold text-lg">Support Team sent you an email</h3>
                            <p class="text-gray-600">Sample email content from the support team.</p>
                        </div>
                    </div>
                </div>

                <!-- Settings Tab -->
                <div id="settings" class="block space-y-6">
                    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <div>
                            <label class="block font-medium mb-2">Username</label>
                            <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" class="w-full p-3 border rounded-md">
                        </div>
                        <div>
                            <label class="block font-medium mb-2">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="w-full p-3 border rounded-md">
                        </div>
                        <div>
                            <label class="block font-medium mb-2">Profile Image</label>
                            <input type="file" name="profile_image" class="w-full p-3 border rounded-md">
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600">Update Profile</button>
                    </form>
                </div>

                <!-- Password Tab -->
                <div id="password" class="hidden space-y-6">
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <label class="block font-medium mb-2">New Password</label>
                            <input type="password" name="new_password" class="w-full p-3 border rounded-md">
                        </div>
                        <div>
                            <label class="block font-medium mb-2">Confirm Password</label>
                            <input type="password" name="confirm_password" class="w-full p-3 border rounded-md">
                        </div>
                        <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-md hover:bg-red-600">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleTab(tabId) {
        const tabs = ['timeline', 'settings', 'password'];
        tabs.forEach(id => {
            const el = document.getElementById(id);
            el.classList.toggle('hidden', id !== tabId);
            el.classList.toggle('block', id === tabId);
        });
    }
</script>
