
  <!-- Your clock container -->
  <div id="liveClock" class="my-10"></div>

  <!-- 🧩 Templates required for JS to work -->
  <template id="DatePart">
    <div class="flex flex-col items-center">
      <div x-text="text"></div>
      <div class="text-sm text-gray-400 mt-1" x-text="label"></div>
    </div>
  </template>

  <template id="TimePart">
    <div class="flex flex-col items-center">
      <div x-text="text"></div>
      <div class="text-xs text-gray-500 mt-1" x-text="label"></div>
    </div>
  </template>
