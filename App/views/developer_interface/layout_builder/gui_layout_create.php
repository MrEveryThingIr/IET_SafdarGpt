<div class="max-w-3xl mx-auto mt-10 bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-xl font-bold mb-4">Create Layout Configuration</h2>

    <form action="<?= route('gui.layout.store') ?>" method="POST" class="space-y-4">
        <?= inputField('title', 'Page Title') ?>
        <?= inputField('layout_view', 'Layout View File (e.g., layouts/main_layout)') ?>
        <?= inputField('styles', 'Styles (comma-separated CSS paths)') ?>
        <?= inputField('scripts', 'Scripts (comma-separated JS paths)') ?>

        <div>
        <select name="navbar" id="navbar" class="...">
    <option value="">None</option>
    <?php foreach ($navbars as $file => $name): ?>
        <option value="<?= $file ?>"><?= $name ?> (<?= $file ?>)</option>
    <?php endforeach; ?>
</select>

        </div>

        <div>
            <label for="sidebar" class="block text-gray-700 font-medium mb-1">Select Sidebar</label>
            <select name="sidebar" id="sidebar" class="w-full p-2 border rounded">
                <option value="">None</option>
                <?php foreach ($sidebars as $id => $name): ?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save & Preview
        </button>
    </form>
</div>
