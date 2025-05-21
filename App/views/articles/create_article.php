<?php isset($_SESSION['error'])?errorMessage():'' ?>

<form action="<?= route('ietarticles.store') ?>" method="POST" class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md space-y-6">
    <?= csrf('field') ?? '' ?>
    <input type="hidden" name="author_id" value="<?= user()['id'] ?>">

    <!-- Title & Slug -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                placeholder="Enter article title" 
                required>
        </div>
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-gray-500">(optional)</span></label>
            <input 
                type="text" 
                id="slug" 
                name="slug" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                placeholder="e.g., how-to-learn-php">
            <p class="text-xs text-gray-500 mt-1">Leave blank to auto-generate</p>
        </div>
    </div>

    <!-- Field / Category & Language -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
             
            <label for="field_category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select 
                id="field_category_id" 
                name="field_category_id" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category) :?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['cate_name'] ?></option>
                <?php endforeach?>
                <!-- Add more as needed -->
            </select>
        </div>

        <div>
            <label for="language_code" class="block text-sm font-medium text-gray-700 mb-1">Language</label>
            <select 
                id="language_code" 
                name="language_code" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                required>
                <option value="fa" selected>فارسی</option>
                <option value="en">English</option>
                <option value="ar">العربية</option>
                <!-- Extend as needed -->
            </select>
        </div>
    </div>

    <!-- Keywords & Reading Time -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="key_words" class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
            <input 
                type="text" 
                id="key_words" 
                name="key_words" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                maxlength="255"
                placeholder="e.g., php, mysql, backend">
            <p class="text-xs text-gray-500 mt-1">Comma-separated, for SEO/tags</p>
        </div>

        <div>
            <label for="time_to_read" class="block text-sm font-medium text-gray-700 mb-1">Time to Read <span class="text-gray-500">(minutes)</span></label>
            <input 
                type="number" 
                id="time_to_read" 
                name="time_to_read" 
                min="1"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                placeholder="e.g., 5">
        </div>
    </div>

    <!-- Status -->
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <div class="flex items-center gap-6">
            <label class="inline-flex items-center">
                <input type="radio" name="status" value="draft" checked class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">Draft</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="status" value="published" class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">Published</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="status" value="archived" class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">Archived</span>
            </label>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end pt-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
            </svg>
            Create Article
        </button>
    </div>
</form>
