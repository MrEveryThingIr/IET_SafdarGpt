export function initMediaUploader(inputSelector, previewContainerSelector, options = {}) {
    const input = document.querySelector(inputSelector);
    const previewContainer = document.querySelector(previewContainerSelector);
    
    if (!input || !previewContainer) {
      console.warn('[mediaUploader] Missing input or preview container');
      return;
    }
  
    input.setAttribute('multiple', options.multiple ? 'multiple' : '');
    if (options.accept) input.setAttribute('accept', options.accept.join(','));
  
    input.addEventListener('change', (e) => {
      previewContainer.innerHTML = ''; // Clear previews
      const files = Array.from(e.target.files);
  
      files.forEach(file => {
        const fileType = file.type;
  
        const mediaElem = (() => {
          if (fileType.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '150px';
            return img;
          } else if (fileType.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            video.style.maxWidth = '150px';
            return video;
          } else if (fileType.startsWith('audio/')) {
            const audio = document.createElement('audio');
            audio.src = URL.createObjectURL(file);
            audio.controls = true;
            return audio;
          } else {
            const span = document.createElement('span');
            span.textContent = `Unsupported file type: ${file.name}`;
            return span;
          }
        })();
  
        previewContainer.appendChild(mediaElem);
      });
    });
  }
  