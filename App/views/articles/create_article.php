<form action="/articles/store" method="POST" class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <!-- CSRF Token (if needed) -->
    <?php echo csrf('field') ?? '' ?>
     <input type="hidden" name="author_id" id="author_id" value="<?php echo user()['id'] ?>">
   
 <!-- Two Column Layout for Time and Language -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Title -->
    <div class="mb-6">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input 
            type="text" 
            id="title" 
            name="title" 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            placeholder="Enter article title" 
            required>
    </div>

        <!-- Slug (optional override) -->
    <div class="mb-6">
        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-gray-500">(optional)</span></label>
        <input 
            type="text" 
            id="slug" 
            name="slug" 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            placeholder="e.g., how-to-learn-php">
        <p class="mt-1 text-xs text-gray-500">Leave blank to auto-generate</p>
    </div>

    <div>
        <!-- Field / Category -->
     
            <label for="field" class="block text-sm font-medium text-gray-700 mb-1">Field / Category</label>
            <input type="text" name="field" id="field" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
           
        
    </div>

    </div>
  
    <!-- Two Column Layout for Time and Language -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
          <!-- Key Words -->
    <div class="mb-6">
        <label for="key_words" class="block text-sm font-medium text-gray-700 mb-1">Keywords</label>
        <input 
            type="text" 
            id="key_words" 
            name="key_words" 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            placeholder="comma, separated, keywords">
        <p class="mt-1 text-xs text-gray-500">Separate with commas for multiple keywords</p>
    </div>

        <!-- Reading Time -->
        <div>
            <label for="time_to_read" class="block text-sm font-medium text-gray-700 mb-1">Time to Read (minutes)</label>
            <input 
                type="number" 
                id="time_to_read" 
                name="time_to_read" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                min="1"
                placeholder="e.g., 5">
        </div>

        <!-- Language -->
        <div>
            <label for="language_code" class="block text-sm font-medium text-gray-700 mb-1">Language</label>
            <select name="language_code" id="language_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <?php foreach ($languages as $code => $label): ?>
                    <option value="<?= $code ?>"><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Status -->
    <div class="mb-8">
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <div class="grid grid-cols-3 gap-2">
            <label class="inline-flex items-center">
                <input type="radio" name="status" value="draft" class="h-4 w-4 text-blue-600 focus:ring-blue-500" checked>
                <span class="ml-2 text-gray-700">Draft</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="status" value="published" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">Published</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="status" value="archived" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700">Archived</span>
            </label>
        </div>
    </div>

    <!-- Submit -->
    <div class="flex justify-end">
        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md transition duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
            </svg>
            Create Article
        </button>
    </div>
</form>