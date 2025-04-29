<h1 class="text-2xl font-bold mb-6 text-center">📋 My Scheduled Meetings</h1>

<?php if (!$meetings): ?>
    <p class="text-gray-600 text-center">No meetings scheduled yet.</p>
<?php else: ?>
    <div class="max-w-4xl mx-auto space-y-4">
        <?php foreach ($meetings as $meeting): ?>
            <div class="bg-white shadow-sm rounded-lg p-4 border border-gray-200">
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($meeting['title']) ?></h2>
                <p class="text-sm text-gray-600">Room Code: <code><?= htmlspecialchars($meeting['room_code']) ?></code></p>
                <p class="text-sm text-gray-600">Scheduled At: <?= htmlspecialchars($meeting['scheduled_at']) ?></p>
                <a href="<?= route('ietmeeting.show', ['id' => $meeting['id']]) ?>"
                   class="text-blue-600 hover:underline text-sm inline-block mt-2">View Details →</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<a href="<?= route('ietmeeting.join', ['id' => $meeting['id']]) ?>" 
   class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    Join Meeting
</a>
