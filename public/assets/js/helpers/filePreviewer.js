/**
 * Initialize preview of selected media files
 *
 * @param {string} inputSelector - <input type="file">
 * @param {string} previewSelector - container to render new file previews
 * @param {Object} [options]
 * @param {boolean} [options.clearOnChange=true]
 */
// filePreviewer.js – corrected version
export function initMediaPreviewer(inputSelector, previewSelector, options = {}) {
  const input     = document.querySelector(inputSelector);
  const container = document.querySelector(previewSelector);
  const clearOnChange = options.clearOnChange !== false;

  if (!input || !container) {
    console.warn('[filePreviewer] Input or preview container not found.');
    return;
  }

  // 1) Ensure `multiple`
  if (!input.hasAttribute('multiple')) {
    input.setAttribute('multiple', '');
  }

  // 2) Ensure `name` ends with []
  const nameAttr = input.getAttribute('name') || '';
  if (!nameAttr.endsWith('[]')) {
    const base = nameAttr.replace(/\[\]$/, '');
    input.setAttribute('name', base + '[]');
  }

  input.addEventListener('change', () => {
    if (clearOnChange) container.innerHTML = '';

    Array.from(input.files).forEach(file => {
      const reader = new FileReader();
      reader.onload = ({ target }) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'border rounded overflow-hidden w-32 h-32 relative m-1';

        if (file.type.startsWith('image/')) {
          wrapper.innerHTML = `<img src="${target.result}" class="object-cover w-full h-full">`;
        } else if (file.type.startsWith('video/')) {
          wrapper.innerHTML = `<video src="${target.result}" controls class="object-cover w-full h-full"></video>`;
        } else {
          wrapper.innerHTML = `<p class="text-xs text-gray-600 p-2 break-all">${file.name}</p>`;
        }

        container.appendChild(wrapper);
      };
      reader.readAsDataURL(file);
    });
  });
}



/**
 * Render existing media (images/videos) as editable previews
 *
 * @param {Array<string>} mediaUrls
 * @param {string} containerSelector
 */
export function initExistingMediaPreviewer(mediaUrls, containerSelector) {
  const container = document.querySelector(containerSelector);
  if (!container) {
    console.warn('[existingMediaPreviewer] Container not found:', containerSelector);
    return;
  }

  container.innerHTML = '';
  mediaUrls.forEach(url => {
    const wrapper = document.createElement('div');
    wrapper.className = 'relative w-32 h-32 border rounded overflow-hidden';

    let content = '';
    if (/\.(jpe?g|png|gif|webp|svg)$/i.test(url)) {
      content = `<img src="${url}" class="object-cover w-full h-full">`;
    } else if (/\.(mp4|webm|ogg)$/i.test(url)) {
      content = `<video src="${url}" controls class="object-cover w-full h-full"></video>`;
    } else {
      content = `<p class="text-xs text-gray-600">${url}</p>`;
    }

    const checkbox = `<input type="checkbox" name="keep_media[]" value="${url}" checked
                        class="absolute top-1 left-1 w-4 h-4 bg-white">`;

    wrapper.innerHTML = checkbox + content;
    container.appendChild(wrapper);
  });
}
