<div class="w-full bg-white border-b border-gray-200 px-4">
    <div class="flex items-center justify-between h-16 mx-auto max-w-7xl">
        <!-- Left side: brand or logo -->
        <div class="flex items-center">
            <span class="font-bold text-xl mr-4">
                <?php echo htmlspecialchars($brand ?? 'MyApp'); ?>
            </span>
            <!-- Example nav items -->
            <?php if (!empty($items) && is_array($items)): ?>
                <ul class="flex gap-4">
                    <?php foreach ($items as $label => $link): ?>
                        <li>
                            <a href="<?php echo htmlspecialchars($link); ?>" class="hover:underline">
                                <?php echo htmlspecialchars($label); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Right side: just a placeholder for icons, login, etc. -->
        <div class="flex items-center space-x-4">
            <a href="#" class="text-gray-600 hover:text-gray-800">Notifications</a>
            <a href="#" class="text-gray-600 hover:text-gray-800">Profile</a>
            <form action="#" method="POST" class="inline">
                <button type="submit" class="text-gray-600 hover:text-gray-800">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
