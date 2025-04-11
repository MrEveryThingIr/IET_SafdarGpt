<div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Define a New Activity</h2>
    <form id="activityForm">
        <div class="mb-4">
            <label for="monthlyGoalId" class="block text-sm font-medium text-gray-700">Monthly Goal</label>
            <select id="monthlyGoalId" name="monthlyGoalId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <!-- Populate with monthly goals from the database -->
                <option value="1">Research Language Learning Apps</option>
                <option value="2">Complete Online Course</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="activityTitle" class="block text-sm font-medium text-gray-700">Activity Title</label>
            <input type="text" id="activityTitle" name="activityTitle" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="totalTimeExpected" class="block text-sm font-medium text-gray-700">Total Time Expected (hours)</label>
            <input type="number" id="totalTimeExpected" name="totalTimeExpected" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="divisionsCount" class="block text-sm font-medium text-gray-700">Divisions Count</label>
            <input type="number" id="divisionsCount" name="divisionsCount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Activity</button>
    </form>
</div>