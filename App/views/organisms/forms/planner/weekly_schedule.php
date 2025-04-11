<div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Define a New Weekly Schedule</h2>
    <form id="weeklyScheduleForm">
        <div class="mb-4">
            <label for="activityId" class="block text-sm font-medium text-gray-700">Activity</label>
            <select id="activityId" name="activityId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <!-- Populate with activities from the database -->
                <option value="1">Research Language Learning Apps</option>
                <option value="2">Complete Online Course</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="weekNumber" class="block text-sm font-medium text-gray-700">Week Number</label>
            <input type="number" id="weekNumber" name="weekNumber" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="plannedTime" class="block text-sm font-medium text-gray-700">Planned Time (hours)</label>
            <input type="number" id="plannedTime" name="plannedTime" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Weekly Schedule</button>
    </form>
</div>