<h1 class="text-2xl font-bold mb-6 text-center">📅 Schedule a New Meeting</h1>

<form action="<?= route('ietmeeting.store') ?>" method="post" class="max-w-xl mx-auto space-y-6 bg-white shadow-md rounded-lg p-6">
    <div>
        <label for="title" class="block text-gray-700 font-medium mb-2">Meeting Title</label>
        <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300" required>
    </div>

    <div>
        <label for="room_code" class="block text-gray-700 font-medium mb-2">Room Code</label>
        <input type="text" name="room_code" id="room_code" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300" required>
    </div>

    <div>
        <label for="scheduled_at" class="block text-gray-700 font-medium mb-2">Schedule Date & Time</label>
        <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300" required>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        ✅ Schedule Meeting
    </button>

    <div class="flex items-center space-x-2">
    <input type="checkbox" id="is_instant" name="is_instant" value="1"
           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
    <label for="is_instant" class="text-sm text-gray-700">Hold this meeting instantly</label>
</div>

<div>
    <label for="password" class="block text-gray-700 font-medium mb-2">Meeting Password (optional)</label>
    <input type="text" name="password" id="password"
           class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300">
</div>

</form>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const isInstantCheckbox = document.getElementById('is_instant');
    const scheduleField = document.getElementById('scheduled_at').closest('div');

    function toggleScheduleField() {
        if (isInstantCheckbox.checked) {
            scheduleField.style.display = 'none';
            document.getElementById('scheduled_at').removeAttribute('required');
        } else {
            scheduleField.style.display = 'block';
            document.getElementById('scheduled_at').setAttribute('required', 'required');
        }
    }

    isInstantCheckbox.addEventListener('change', toggleScheduleField);
    toggleScheduleField(); // Initial state
});
</script>
