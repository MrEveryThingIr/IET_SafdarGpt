<?php /** @var string $roomCode */ ?>

<div class="max-w-6xl mx-auto mt-8 p-4 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4 text-center text-gray-700">🔗 Live Meeting</h1>
    <iframe 
        src="https://meet.jit.si/<?= urlencode($roomCode) ?>" 
        allow="camera; microphone; fullscreen; display-capture"
        style="width: 100%; height: 700px; border: none; border-radius: 10px;"
        title="Jitsi Meeting"></iframe>
</div>
