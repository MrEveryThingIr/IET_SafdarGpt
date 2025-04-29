<div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
  <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">📝 Create New Post</h1>

  <form action="<?= route('ietpost.store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">

    <!-- Title -->
    <div>
      <label for="title" class="block font-semibold text-gray-700 mb-1">Post Title</label>
      <input type="text" id="title" name="title" required
             class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Content -->
    <div>
      <label for="content" class="block font-semibold text-gray-700 mb-1">Content</label>
      <textarea id="content" name="content" rows="5" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
    </div>

    <!-- Media Type -->
    <div>
      <label class="block font-semibold text-gray-700 mb-1">Media Type</label>
      <select name="media_type" required
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="" disabled selected>Choose media type</option>
        <option value="image">Image</option>
        <option value="video">Video</option>
      </select>
    </div>

    <!-- Media Upload -->
    <div>
      <label for="media" class="block font-semibold text-gray-700 mb-1">Upload or Capture Media</label>

      <!-- Upload Option -->
      <input type="file" id="media" name="media" accept="image/*,video/*"
             class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100 mb-3"/>

      <!-- Webcam Preview -->
      <video id="cameraPreview" autoplay playsinline class="w-full max-h-64 border rounded-lg mb-3"></video>

      <!-- Media Buttons -->
      <div class="flex flex-wrap gap-4 mb-3">
        <button type="button" id="startCamera" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">📸 Start Camera</button>
        <button type="button" id="takePhoto" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded hidden">📷 Take Photo</button>
        <button type="button" id="startRecording" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded hidden">🎥 Start Recording</button>
        <button type="button" id="stopRecording" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded hidden">🛑 Stop</button>
      </div>

      <!-- Captured Preview -->
      <div id="capturePreview" class="mb-3"></div>

      <!-- Hidden Base64 -->
      <input type="hidden" name="captured_media" id="capturedMediaBase64" />
    </div>

    <!-- Keywords -->
    <div>
      <label for="keywords" class="block font-semibold text-gray-700 mb-1">Keywords <span class="text-sm text-gray-500">(comma-separated)</span></label>
      <input type="text" id="keywords" name="keywords"
             placeholder="e.g. finance,crypto,education"
             class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
    </div>

    <!-- Visibility -->
    <div>
      <label for="visibility" class="block font-semibold text-gray-700 mb-1">Visibility</label>
      <select name="visibility" id="visibility"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="published" selected>🌍 Public (Published)</option>
        <option value="archived">🔒 Archived (Private)</option>
      </select>
    </div>

    <!-- Submit -->
    <div class="text-center">
      <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
        📤 Submit Post
      </button>
    </div>
  </form>
</div>

<!-- Media Script -->
<script type="module">
 import MediaCaptureHelper from <?php echo base_url('assets/js/safdar_lib/plugins/auto/MediaCaptureHelper.js')?>;
  const mediaHelper = new MediaCaptureHelper({
    videoSelector: '#cameraPreview',
    previewSelector: '#capturePreview',
    inputSelector: '#capturedMediaBase64'
  });

  document.getElementById('startCamera').addEventListener('click', () => {
    mediaHelper.startCamera();
    document.getElementById('takePhoto').classList.remove('hidden');
    document.getElementById('startRecording').classList.remove('hidden');
  });

  document.getElementById('takePhoto').addEventListener('click', () => mediaHelper.takePhoto());
  document.getElementById('startRecording').addEventListener('click', () => {
    mediaHelper.startRecording();
    document.getElementById('stopRecording').classList.remove('hidden');
  });
  document.getElementById('stopRecording').addEventListener('click', () => mediaHelper.stopRecording());
</script>
