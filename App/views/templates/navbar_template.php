<nav class="bg-white border-b border-gray-300 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Brand/Logo -->
            <div class="flex-shrink-0 flex items-center">
                <?php if (is_array($brand)): ?>
                    <?php
                        $brandLabel = $brand['label'] ?? 'Brand';
                        $brandHref = $brand['href'] ?? null;
                        $brandClass = $brand['class'] ?? 'text-xl font-bold text-gray-800';
                        $brandHtml = $brand['html'] ?? null;
                        $brandIcon = $brand['icon'] ?? '';
                        $brandAttributes = '';
                        
                        if (!empty($brand['attributes'])) {
                            foreach ($brand['attributes'] as $key => $val) {
                                $brandAttributes .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($val));
                            }
                        }
                    ?>
                    <?php if ($brandHtml): ?>
                        <?= $brandHtml ?>
                    <?php elseif ($brandHref): ?>
                        <a href="<?= htmlspecialchars($brandHref) ?>" class="<?= $brandClass ?>" <?= $brandAttributes ?>>
                            <?= $brandIcon ?> <?= htmlspecialchars($brandLabel) ?>
                        </a>
                    <?php else: ?>
                        <div class="<?= $brandClass ?>" <?= $brandAttributes ?>>
                            <?= $brandIcon ?> <?= htmlspecialchars($brandLabel) ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-xl font-bold text-gray-800">
                        <?= htmlspecialchars($brand ?? 'Brand') ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                        <?php foreach ($items as $item): ?>
                <?php
                    $label = $item['label'] ?? 'Link';
                    $href = $item['href'] ?? '#';
                    $class = $item['class'] ?? 'text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium';
                    $icon = $item['icon'] ?? '';
                    $html = $item['html'] ?? null;
                    $attributes = '';
                    $isForm = $item['form'] ?? false;
                    $action = $item['action'] ?? '';
                    $method = $item['method'] ?? 'POST';

                    if (!empty($item['attributes'])) {
                        foreach ($item['attributes'] as $key => $val) {
                            $attributes .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($val));
                        }
                    }
                ?>
                <?php if ($html): ?>
                    <?= $html ?>
                <?php elseif ($isForm): ?>
                    <form action="<?= htmlspecialchars($action) ?>" method="<?= htmlspecialchars($method) ?>" class="inline">
                        <?= csrf('field') ?>
                        <button type="submit" class="<?= $class ?>" <?= $attributes ?>>
                            <?= $icon ?> <?= htmlspecialchars($label) ?>
                        </button>
                    </form>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($href) ?>" class="<?= $class ?>" <?= $attributes ?>>
                        <?= $icon ?> <?= htmlspecialchars($label) ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <?php foreach ($items as $item): ?>
    <?php
        $label = $item['label'] ?? 'Link';
        $href = $item['href'] ?? '#';
        $class = $item['class'] ?? 'text-gray-700 hover:text-blue-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium';
        $icon = $item['icon'] ?? '';
        $html = $item['html'] ?? null;
        $attributes = '';
        $isForm = $item['form'] ?? false;
        $action = $item['action'] ?? '';
        $method = $item['method'] ?? 'POST';

        if (!empty($item['attributes'])) {
            foreach ($item['attributes'] as $key => $val) {
                $attributes .= sprintf(' %s="%s"', htmlspecialchars($key), htmlspecialchars($val));
            }
        }
    ?>
    <?php if ($html): ?>
        <?= $html ?>
    <?php elseif ($isForm): ?>
        <form action="<?= htmlspecialchars($action) ?>" method="<?= htmlspecialchars($method) ?>" class="block">
            <?= csrf('field') ?>
            <button type="submit" class="<?= $class ?> w-full text-left" <?= $attributes ?>>
                <?= $icon ?> <?= htmlspecialchars($label) ?>
            </button>
        </form>
    <?php else: ?>
        <a href="<?= htmlspecialchars($href) ?>" class="<?= $class ?>" <?= $attributes ?>>
            <?= $icon ?> <?= htmlspecialchars($label) ?>
        </a>
    <?php endif; ?>
<?php endforeach; ?>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            // Toggle menu visibility
            mobileMenu.classList.toggle('hidden');
            
            // Toggle hamburger/close icons
            const icons = mobileMenuButton.querySelectorAll('svg');
            icons.forEach(icon => icon.classList.toggle('hidden'));
            icons.forEach(icon => icon.classList.toggle('block'));
            
            // Update aria-expanded attribute
            const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !expanded);
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (mobileMenu && !mobileMenu.contains(event.target) && 
            mobileMenuButton && !mobileMenuButton.contains(event.target) &&
            !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            const icons = mobileMenuButton.querySelectorAll('svg');
            icons[0].classList.remove('hidden');
            icons[0].classList.add('block');
            icons[1].classList.remove('block');
            icons[1].classList.add('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>