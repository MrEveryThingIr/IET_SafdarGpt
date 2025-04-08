<div class="hidden md:flex flex-col w-56 bg-gray-800">
    <div class="flex flex-col flex-1 p-3 text-white">
        <nav class="flex flex-col gap-3">
            <?php if (!empty($items) && is_array($items)): ?>
                <?php foreach ($items as $item): ?>
                    <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700">
                        <?php echo htmlspecialchars($item); ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="px-3 py-2">No sidebar items</p>
            <?php endif; ?>
        </nav>
    </div>
</div>
