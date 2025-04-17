<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Create New Form</title>
</head>
<body class="bg-gray-50 p-6 text-gray-800">

  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-3xl font-bold mb-6">Create New Form</h1>

    <form action="<?= route('gui.form.preview') ?>" method="post" class="space-y-5">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="formname" class="block text-sm font-medium mb-1">Form Name</label>
          <input type="text" name="formname" id="formname" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
          <label for="action" class="block text-sm font-medium mb-1">Action URL</label>
          <input type="text" name="action" id="action" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
          <label for="method" class="block text-sm font-medium mb-1">HTTP Method</label>
          <input type="text" name="method" id="method" value="post" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
          <label for="submitbutton" class="block text-sm font-medium mb-1">Submit Button Text</label>
          <input type="text" name="submitbutton" id="submitbutton" value="Post" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
      </div>

      <div>
        <label for="classes" class="block text-sm font-medium mb-1">Classes for styles or JS</label>
        <textarea name="classes" id="classes" rows="3" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>

      <div class="flex flex-wrap gap-4">
        <button type="button" class="add_input bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Add Input</button>
        <button type="button" class="add_selectoption bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">Add Select Option</button>
      </div>

      <div id="input-container">
        <fieldset class="input hidden border border-gray-300 rounded-md p-4 space-y-4">
          <legend class="text-lg font-semibold mb-2">Input Field</legend>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="name[]" placeholder="Input name" class="border border-gray-300 px-3 py-2 rounded-md" />
            <input type="text" name="placeholder[]" placeholder="Placeholder" class="border border-gray-300 px-3 py-2 rounded-md" />
            <input type="text" name="id[]" placeholder="ID" class="border border-gray-300 px-3 py-2 rounded-md" />
            <input type="text" name="value[]" placeholder="Value" class="border border-gray-300 px-3 py-2 rounded-md" />
            <input type="text" name="class[]" placeholder="Class" list="class-list" class="border border-gray-300 px-3 py-2 rounded-md" />
                <datalist id="class-list">
                <option value="form-input" />
                <option value="rounded-md" />
                <option value="shadow-sm" />
                <option value="text-gray-700" />
                <option value="bg-white" />
                <option value="focus:ring-2" />
                </datalist>
            <select name="type[]" class="border border-gray-300 px-3 py-2 rounded-md">
  <option value="">Select type</option>

  <optgroup label="Text Inputs">
    <option value="text">Text</option>
    <option value="email">Email</option>
    <option value="password">Password</option>
    <option value="search">Search</option>
    <option value="tel">Telephone</option>
    <option value="url">URL</option>
  </optgroup>

  <optgroup label="Numeric & Date">
    <option value="number">Number</option>
    <option value="range">Range</option>
    <option value="date">Date</option>
    <option value="time">Time</option>
    <option value="month">Month</option>
    <option value="week">Week</option>
    <option value="datetime-local">Datetime-Local</option>
  </optgroup>

  <optgroup label="Choice Inputs">
    <option value="checkbox">Checkbox</option>
    <option value="radio">Radio</option>
  </optgroup>

  <optgroup label="File & Hidden">
    <option value="file">File</option>
    <option value="hidden">Hidden</option>
    <option value="color">Color Picker</option>
  </optgroup>

  <optgroup label="Buttons">
    <option value="submit">Submit</option>
    <option value="reset">Reset</option>
    <option value="button">Button</option>
  </optgroup>
</select>

          </div>
        </fieldset>
      </div>

      <div id="select-container">
        <fieldset class="selectoption hidden border border-gray-300 rounded-md p-4">
          <legend class="text-lg font-semibold mb-2">Select Field</legend>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <input type="text" name="select_name[]" placeholder="Select name" class="border border-gray-300 px-3 py-2 rounded-md" />
            <input type="text" name="select_id[]" placeholder="Select ID" class="border border-gray-300 px-3 py-2 rounded-md" />
          </div>

          <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Classes</label>
            <textarea name="select_classes[]" rows="2" class="w-full border border-gray-300 px-3 py-2 rounded-md"></textarea>
          </div>

          <button type="button" class="addoption bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition">Add Option</button>

          <div class="option-container">
            <fieldset class="option hidden mt-4 border border-gray-300 p-3 rounded-md">
              <legend class="text-sm font-semibold mb-2">Option</legend>
              <input type="text" name="option_label[]" placeholder="Label" class="w-full mb-2 border border-gray-300 px-3 py-2 rounded-md" />
              <input type="text" name="option_value[]" placeholder="Value" class="w-full border border-gray-300 px-3 py-2 rounded-md" />
            </fieldset>
          </div>
        </fieldset>
      </div>

      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md mt-4 transition">Submit</button>
    </form>
  </div>

</body>
</html>
