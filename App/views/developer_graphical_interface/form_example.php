<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Advanced Form Example</h2>
    
    <form class="space-y-6">
      
      <!-- Text Input -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Full Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="full_name" required
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Email Address
        </label>
        <input type="email" name="email"
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Password -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Password
        </label>
        <input type="password" name="password"
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Phone -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Phone Number
        </label>
        <input type="tel" name="phone"
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- URL -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Website
        </label>
        <input type="url" name="website"
               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Date -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Birthdate
        </label>
        <input type="date" name="birthdate"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Time -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Appointment Time
        </label>
        <input type="time" name="appointment"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- File Upload -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Upload Resume
        </label>
        <input type="file" name="resume"
               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
      </div>

      <!-- Select Dropdown -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Role
        </label>
        <select name="role"
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option>User</option>
          <option>Admin</option>
          <option>Super Admin</option>
        </select>
      </div>

      <!-- Radio Buttons -->
      <fieldset>
        <legend class="block text-sm font-medium text-gray-700 mb-1">Gender</legend>
        <div class="flex space-x-4">
          <label class="flex items-center space-x-2">
            <input type="radio" name="gender" value="male" class="text-blue-600">
            <span>Male</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" name="gender" value="female" class="text-blue-600">
            <span>Female</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="radio" name="gender" value="other" class="text-blue-600">
            <span>Other</span>
          </label>
        </div>
      </fieldset>

      <!-- Checkboxes -->
      <fieldset>
        <legend class="block text-sm font-medium text-gray-700 mb-1">Skills</legend>
        <div class="grid grid-cols-2 gap-2">
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="skills[]" value="php" class="text-blue-600">
            <span>PHP</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="skills[]" value="js" class="text-blue-600">
            <span>JavaScript</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" name="skills[]" value="python" class="text-blue-600">
            <span>Python</span>
          </label>
        </div>
      </fieldset>

      <!-- Toggle Switch -->
      <div class="flex items-center space-x-2">
        <label for="subscribe" class="text-sm font-medium text-gray-700">Subscribe to newsletter</label>
        <input type="checkbox" id="subscribe" name="subscribe" class="toggle-checkbox hidden">
        <div class="relative w-10 h-5 bg-gray-300 rounded-full cursor-pointer transition">
          <div class="absolute left-0 top-0 w-5 h-5 bg-white rounded-full shadow transition transform"></div>
        </div>
      </div>

      <!-- Range -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Satisfaction (1 to 10)
        </label>
        <input type="range" name="satisfaction" min="1" max="10"
               class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer">
      </div>

      <!-- Textarea -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          Additional Comments
        </label>
        <textarea name="comments" rows="4"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>

      <!-- Error Style Example -->
      <div>
        <label class="block text-sm font-medium text-red-700 mb-1">
          Username (Error Example)
        </label>
        <input type="text" class="w-full px-4 py-2 border border-red-500 rounded-md bg-red-50 text-red-700" value="bad_input">
        <p class="text-sm text-red-600 mt-1">This username is already taken.</p>
      </div>

      <!-- Buttons -->
      <div class="flex space-x-4 pt-4">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-semibold">
          Submit
        </button>
        <button type="reset"
                class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition font-semibold">
          Reset
        </button>
      </div>
    </form>
  </div>