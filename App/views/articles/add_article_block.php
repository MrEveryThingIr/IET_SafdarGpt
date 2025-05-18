<!-- Form to create a new article block -->
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create New Article Block</h2>
    <form method="post" action="save_block.php" class="space-y-4">
        <input type="hidden" name="article_id" value="<?= htmlspecialchars($articleId) ?>">
        
        <div>
            <label for="block_type" class="block text-sm font-medium text-gray-700 mb-1">Block Type</label>
            <select name="block_type" id="block_type" required onchange="toggleFields()" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Select --</option>
                <option value="paragraph">Paragraph</option>
                <option value="heading">Heading</option>
                <option value="image">Image</option>
                <option value="list">List</option>
                <option value="quote">Quote</option>
                <option value="divider">Divider</option>
                <option value="embed">Embed</option>
                <option value="cta">CTA</option>
                <option value="faq">FAQ</option>
                <option value="video">Video</option>
                <option value="audio">Audio</option>
            </select>
        </div>

        <div id="common-fields" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                <input type="number" name="block_order" min="0" value="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CSS Class (optional)</label>
                <input type="text" name="css_class"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                <input type="text" name="language_code" value="en"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div id="field-content" class="hidden">
            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea name="content" rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>

        <div id="field-heading" class="hidden">
            <label class="block text-sm font-medium text-gray-700 mb-1">Heading Level (1–6)</label>
            <input type="number" name="heading_level" min="1" max="6"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div id="field-image" class="hidden space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                <input type="text" name="image_url"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                <input type="text" name="image_alt"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
                <input type="text" name="image_caption"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div id="field-list" class="hidden space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">List Type</label>
                <select name="list_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="unordered">Unordered</option>
                    <option value="ordered">Ordered</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">List Items (one per line)</label>
                <textarea name="list_items" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
        </div>

        <button type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Save Block
        </button>
    </form>
</div>

<script>
function toggleFields() {
    const type = document.getElementById('block_type').value;
    document.getElementById('field-content').classList.toggle('hidden', !['paragraph', 'quote', 'faq', 'cta', 'embed', 'video', 'audio'].includes(type));
    document.getElementById('field-heading').classList.toggle('hidden', type !== 'heading');
    document.getElementById('field-image').classList.toggle('hidden', type !== 'image');
    document.getElementById('field-list').classList.toggle('hidden', type !== 'list');
}
</script>