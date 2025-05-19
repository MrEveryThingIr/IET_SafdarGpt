<!-- views/categories/show_category.php -->

<div class="container mx-auto p-6">
  <!-- Flash Messages -->
  <div class="space-y-2">
    <?php isset($_SESSION['error']) ? errorMessage() : '' ?>
    <?php isset($_SESSION['success']) ? errorMessage() : '' ?>
  </div>
    <!-- Main Category Details -->
<div class="mb-12">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b pb-2 border-gray-200">
        Main Category Details
    </h2>

    <div class="bg-white shadow-md hover:shadow-lg transition-shadow duration-300 p-6 rounded-lg border border-gray-100">
        <div class="space-y-4 text-gray-700 text-base leading-relaxed">
            <p>
                <span class="font-semibold text-gray-600">ID:</span>
                <?= htmlspecialchars($main_category['id']) ?>
            </p>
            <p>
                <span class="font-semibold text-gray-600">Name:</span>
                <?= htmlspecialchars($main_category['cate_name']) ?>
            </p>
            <p>
                <span class="font-semibold text-gray-600">Description:</span>
                <?= htmlspecialchars($main_category['description']) ?>
            </p>
        </div>

        <div class="mt-6">
            <a href="<?= route('ietcategories.all') ?>"
               class="inline-block text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200 border border-blue-100 hover:border-blue-300 px-4 py-2 rounded shadow-sm bg-blue-50 hover:bg-blue-100 rtl:text-right">
               بازگشت
            </a>
        </div>
    </div>
</div>


    <!-- Add SubCategory Form -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-2">Add SubCategory</h3>
        <form action="<?php echo route('ietcategories.sub.store')?>" method="POST" class="flex flex-wrap gap-4 items-end bg-gray-50 p-4 rounded shadow">
            <?php echo csrf('field') ?>
            <input type="hidden" name="main_cate_id" value="<?= htmlspecialchars($main_category['id']) ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="cate_name">SubCategory Name</label>
                <input type="text" name="cate_name" id="cate_name" required class="border border-gray-300 px-3 py-2 rounded w-64">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="key_words">Keywords</label>
                <input type="text" name="key_words" id="key_words" class="border border-gray-300 px-3 py-2 rounded w-64">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" for="description">Description</label>
                <input type="text" name="description" id="description" class="border border-gray-300 px-3 py-2 rounded w-64">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Add
            </button>
        </form>
    </div>

    <!-- SubCategories Table -->
    <div>
        <h3 class="text-xl font-semibold mb-4">SubCategories</h3>
        <table class="min-w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left text-sm uppercase tracking-wider">
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Keywords</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($sub_categories as $sub): ?>
    <tr class="border-t hover:bg-gray-50">
        <td class="px-4 py-2"><?= htmlspecialchars($sub['id']) ?></td>
        <td class="px-4 py-2"><?= htmlspecialchars($sub['cate_name']) ?></td>
        <td class="px-4 py-2"><?= htmlspecialchars($sub['key_words']) ?></td>
        <td class="px-4 py-2"><?= htmlspecialchars($sub['description']) ?></td>
        <td class="px-4 py-2 flex gap-2">
            <form action="<?= route('ietcategories.sub.delete', ['id' => $sub['id']]) ?>" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                <?= csrf('field') ?>
                <input type="hidden" name="main_category_id" value="<?= htmlspecialchars($main_category['id']) ?>">
                <button type="submit" class="text-red-600 hover:underline hover:text-red-800">
                    Delete
                </button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
                <?php if (empty($sub_categories)): ?>
                    <tr><td colspan="5" class="px-4 py-3 text-center text-gray-500">No subcategories found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
