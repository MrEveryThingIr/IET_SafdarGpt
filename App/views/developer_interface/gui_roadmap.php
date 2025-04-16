<?php
/**
 * View: gui_roadmap.php
 * Displays a 14-day roadmap to guide Developer GUI MVP launch
 */
$days = [
    ['day' => 1, 'date' => 'Apr 16', 'task' => 'Finalize centralized JSON system + layout creation preview'],
    ['day' => 2, 'date' => 'Apr 17', 'task' => 'Implement Navbar builder (form + save/load + styling/script)'],
    ['day' => 3, 'date' => 'Apr 18', 'task' => 'Sidebar builder + Form builder form interface (basic fields)'],
    ['day' => 4, 'date' => 'Apr 19', 'task' => 'Form field config system (per input: label, name, type, etc)'],
    ['day' => 5, 'date' => 'Apr 20', 'task' => 'Asset JS/CSS bindings with class/id mapping via AJAX'],
    ['day' => 6, 'date' => 'Apr 21', 'task' => 'Visual preview for injected layout (with navbar/sidebar/form)'],
    ['day' => 7, 'date' => 'Apr 22', 'task' => 'Start GUI Templates/Presets (import/export layout)'],
    ['day' => 8, 'date' => 'Apr 23', 'task' => 'GUI Live Editor: Swap/edit content (navbar items, etc.)'],
    ['day' => 9, 'date' => 'Apr 24', 'task' => 'GUI styles/scripts editor interface'],
    ['day' => 10, 'date' => 'Apr 25', 'task' => 'Versioning + rollback for saved JSON objects'],
    ['day' => 11, 'date' => 'Apr 26', 'task' => 'Final object library browser (list + reuse any object)'],
    ['day' => 12, 'date' => 'Apr 27', 'task' => 'Implement dashboard polish + mobile responsive'],
    ['day' => 13, 'date' => 'Apr 28', 'task' => 'Final validation, test multiple layouts + feedback'],
    ['day' => 14, 'date' => 'Apr 29', 'task' => '🎉 Final deployment, documentation, and promotional preview'],
];
?>

<h1 class="text-2xl font-bold mb-4">🗓 Developer GUI MVP Launch Roadmap</h1>

<table class="table-auto w-full border border-collapse border-gray-300">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-2 border">Day</th>
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Goal / Task</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($days as $d): ?>
            <tr>
                <td class="p-2 border"><?= $d['day'] ?></td>
                <td class="p-2 border"><?= $d['date'] ?></td>
                <td class="p-2 border"><?= $d['task'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
