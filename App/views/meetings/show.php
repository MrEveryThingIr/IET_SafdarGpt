<h1 class="text-2xl font-bold mb-6 text-center">📁 Meeting Details</h1>

<div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6 space-y-4 border border-gray-200">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">Title:</h2>
        <p class="text-gray-700"><?= htmlspecialchars($meeting->title) ?></p>
    </div>

    <div>
        <h2 class="text-lg font-semibold text-gray-800">Room Code:</h2>
        <p class="text-gray-700"><code><?= htmlspecialchars($meeting->room_code) ?></code></p>
    </div>

    <div>
        <h2 class="text-lg font-semibold text-gray-800">Scheduled At:</h2>
        <p class="text-gray-700"><?= htmlspecialchars($meeting->scheduled_at) ?></p>
    </div>

    <div>
        <h2 class="text-lg font-semibold text-gray-800">Created At:</h2>
        <p class="text-gray-500 text-sm"><?= htmlspecialchars($meeting->created_at) ?></p>
    </div>

    <a href="<?= route('ietmeeting.my') ?>" class="text-blue-600 hover:underline text-sm">← Back to My Meetings</a>
</div>

<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg mt-8">
    <h1 class="text-2xl font-bold mb-4"><?= htmlspecialchars($meeting->title) ?></h1>

    <p><strong>Scheduled For:</strong> <?= date('Y-m-d H:i', strtotime($meeting->scheduled_at)) ?></p>
    <p><strong>Room Code:</strong> <?= htmlspecialchars($meeting->room_code) ?></p>

    <div class="mt-6">
        <a href="https://meet.jit.si/<?= urlencode($meeting->room_code) ?>" target="_blank"
           class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
            🔗 Join Meeting
        </a>
    </div>
</div>

<?php if (strtotime($meeting->scheduled_at) > time() && !$meeting->is_instant): ?>
    <p class="text-red-600">⏳ This meeting is not yet started. Please return at the scheduled time.</p>
<?php else: ?>
    <!-- Embed Jitsi iframe -->
<?php endif; ?>


<a href="<?= route('ietmeeting.join', ['id' => $meeting->id]) ?>" 
   class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
    Join Meeting
</a>
