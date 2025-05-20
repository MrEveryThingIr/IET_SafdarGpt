<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'IET Interface') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <?php foreach ($stylesPaths ?? [] as $cssPath): ?>
        <link rel="stylesheet" href="<?= base_url($cssPath) ?>">
    <?php endforeach; ?>
    
</head>
<body data-view=<?= htmlspecialchars($title ?? 'IET Interface') ?> class="bg-gray-100 font-sans flex">

<div class="w-full flex h-screen">
    <?= $sidebarHtml ?? '' ?>
    <div class="flex flex-col flex-1 overflow-y-auto">
        <?= $navbarHtml ?? '' ?>
        <main class="p-4"><?= $content ??  '' ?></main>
    </div>
</div>

<!-- jQuery and validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    window._AUTH_STATE = {
        isLoggedIn: <?= isLoggedIn() ? 'true' : 'false' ?>,
        loginRoute: '<?= route('auth.login') ?>'
    };
</script>

<!-- Always load orchestrator (as constant helper loader) -->
<script type="module">
    import { bootDynamicJsHelpers } from '/assets/js/orchestrator.js';
    bootDynamicJsHelpers('<?= route('ietarticles.js_helpers') ?>');
</script>

<!-- Additional scripts if provided -->
<?php foreach ($scriptsPaths ?? [] as $jsPath): ?>
    <script src="<?= base_url($jsPath) ?>"></script>
<?php endforeach; ?>

</body>
</html>
