<div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Define a New Monthly Goal</h2>
    <form id="monthlyGoalForm">
        <div class="mb-4">
            <label for="yearlyGoalId" class="block text-sm font-medium text-gray-700">Yearly Goal</label>
            <select id="yearlyGoalId" name="yearlyGoalId" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <!-- Populate with yearly goals from the database -->
                <option value="1">Learn a New Language</option>
                <option value="2">Get Promoted</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
            <select id="month" name="month" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="فروردین">فروردین</option>
                <option value="اردیبهشت">اردیبهشت</option>
                <!-- Add all months -->
            </select>
        </div>
        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
            <select id="priority" name="priority" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="phaseName" class="block text-sm font-medium text-gray-700">Phase Name</label>
            <input type="text" id="phaseName" name="phaseName" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Monthly Goal</button>
    </form>
</div>