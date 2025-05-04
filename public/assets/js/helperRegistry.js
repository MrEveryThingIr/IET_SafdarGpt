const helperRegistry = {
    categories: {
      module: '/assets/js/helpers/categoryLoader.js',
      method: 'loadCategories',
      args: ['main_categories', 'sub_categories', '/data/categories.json']
    },
    // filePreview: {
    //   module: '/assets/js/helpers/filePreviewer.js',
    //   method: 'initMediaPreviewer',
    //   args: ['input[name="media_uploads[]"]', '#media_preview', { clearOnChange: false }]
    // },
    existingMedia: {
      module: '/assets/js/helpers/filePreviewer.js',
      method: 'initExistingMediaPreviewer',
      args: [window._EXISTING_MEDIA || [], '#existingMediaContainer']
    },
    mediaUploader: {
      module: '/assets/js/helpers/mediaUploader.js',
      method: 'initMediaUploader',
      args: ['#mediaUploaderInput', '#uploadedMediaList', { accept: ['image/*', 'video/*', 'audio/*'], multiple: true }]
    }
  };
  
  export default helperRegistry;
  