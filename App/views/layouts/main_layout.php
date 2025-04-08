<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title ?? 'My Website'); ?></title>

    <!-- Base or default styles -->
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


    <!-- Dynamically inserted CSS -->
    <?php if (!empty($stylesPaths) && is_array($stylesPaths)): ?>
        <?php foreach ($stylesPaths as $cssPath): ?>
            <link rel="stylesheet" href="<?php echo base_url($cssPath); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="bg-gray-100 font-family-karla flex">

    <div class="w-full flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <?php echo $sidebarHtml; ?>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-y-auto">
            <!-- Navbar -->
            <?php echo $navbarHtml; ?>

            <!-- The main content of the page -->
            <div class="p-4">
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <!-- Base or default scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    
    <!-- Dynamically inserted scripts -->
    <?php if (!empty($scriptsPaths) && is_array($scriptsPaths)): ?>
        <?php foreach ($scriptsPaths as $jsPath): ?>
            <script src="<?php echo base_url($jsPath); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
