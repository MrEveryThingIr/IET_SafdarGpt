<?php showTemporaryMessage('storeData', 'success') ?>

<div class="container mx-auto px-4 py-8">
      <!-- Header and Create Button -->
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">دسته بندیها</h1>
   
  </div>
    <!-- Add Main Category Form -->
<div class="mb-8">

    <form action="<?php echo route('ietcategories.main.store') ?>" method="POST" class="flex flex-wrap gap-4 items-end bg-gray-50 p-4 rounded shadow" dir="rtl">
        <?php echo csrf('field') ?>

        <div>
            <label for="cate_name" class="block text-sm font-medium text-gray-700 mb-1">عنوان دسته‌بندی</label>
            <input
                type="text"
                name="cate_name"
                id="cate_name"
                required
                class="border border-gray-300 px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">توضیحات</label>
            <input
                type="text"
                name="description"
                id="description"
                class="border border-gray-300 px-3 py-2 rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
        >
            افزودن به دسته‌بندی‌ها
        </button>
    </form>
</div>



  <!-- Category Table -->
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if (!empty($categories)): ?>
      <div class="overflow-x-auto">
<table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gray-50">
    <tr>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    <?php foreach ($categories as $category): ?>
      <tr class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($category['id']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          <a href="<?= route('ietcategories.show_main', ['id' => $category['id']]) ?>" class="text-blue-600 hover:text-blue-800 hover:underline">
            <?= htmlspecialchars($category['cate_name']) ?>
          </a>
        </td>
        <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($category['description']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($category['created_at']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($category['updated_at']) ?></td>
             <td class="px-4 py-2">
                            <form action="<?php echo route('ietcategories.main.delete',['id'=>$category['id']]) ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($main['id']) ?>">
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
      </div>
    <?php else: ?>
      <div class="p-8 text-center">
        <p class="text-gray-500">No categories found. Create your first one!</p>
      </div>
    <?php endif; ?>
  </div>
</div>