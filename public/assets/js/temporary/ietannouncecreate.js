// formMediaInit.js
import { initMediaUploader } from '/assets/js/helpers/mediaUploader.js';
import { initMediaPreviewer, initExistingMediaPreviewer } from '/assets/js/helpers/filePreviewer.js';

document.addEventListener('DOMContentLoaded', () => {
  // Detect file input and preview container dynamically (support both create/edit)
  const input = document.querySelector('#mediaUploaderInput, #media_upload');
  const preview = document.querySelector('#uploadedMediaList, #media_preview');

  if (input && preview) {
    initMediaUploader(`#${input.id}`, `#${preview.id}`, {
      multiple: true,
      accept: ['image/*', 'video/*', 'audio/*']
    });

    initMediaPreviewer(`#${input.id}`, `#${preview.id}`, {
      clearOnChange: true
    });
  }

  // Render existing media for edit form
  const existingMediaContainer = document.querySelector('#existingMediaContainer');
  if (existingMediaContainer && window._EXISTING_MEDIA?.length) {
    initExistingMediaPreviewer(window._EXISTING_MEDIA, '#existingMediaContainer');
  }

  // Optional: show debug info and disable submit button during upload
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', function () {
      const fileInput = input;
      console.log('Submitting files:', fileInput?.files);
      const submitBtn = this.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'در حال آپلود...';
      }
    });
  }
});
