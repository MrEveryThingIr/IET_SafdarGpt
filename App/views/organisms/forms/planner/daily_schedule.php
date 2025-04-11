<div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Define a New Daily Schedule</h2>
    <form id="dailyScheduleForm">
        <div class="mb-4">
            <label for="weeklyScheduleId" class="block text-sm font-medium text-gray-700">Weekly Schedule</label>
            <select id="weeklyScheduleId" name="weeklyScheduleId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <!-- Populate with weekly schedules from the database -->
                <option value="1">Week 1: Research Apps</option>
                <option value="2">Week 2: Complete Course</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" id="date" name="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="plannedTime" class="block text-sm font-medium text-gray-700">Planned Time (hours)</label>
            <input type="number" id="plannedTime" name="plannedTime" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Daily Schedule</button>
    </form>
</div>