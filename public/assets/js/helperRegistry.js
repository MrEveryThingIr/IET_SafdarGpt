const helperRegistry = {
    categories: {
      module: '/assets/js/helpers/categoryLoader.js',
      method: 'loadCategories',
      args: ['main_categories', 'sub_categories', '/data/categories.json']
    },
    filePreview: {
        module: '/assets/js/helpers/filePreviewer.js',
        method: 'initMediaPreviewer',
        args: ['input[name="media_uploads[]"]', '#media_preview', { clearOnChange: false }]
      },
      filePreview: {
        module: '/assets/js/helpers/filePreviewer.js',
        method: 'initMediaPreviewer',
        args: ['input[name="files[]"]', '#medias', { clearOnChange: false }]
      },
      existingMedia: {
        module: '/assets/js/helpers/filePreviewer.js',
        method: 'initExistingMediaPreviewer',
        args: [window._EXISTING_MEDIA || [], '#existingMediaContainer']
      }
      
    // Add future helpers here:
    // dragDropUpload: {
    //   module: '/assets/js/helpers/dragDropUploader.js',
    //   method: 'initDropzone',
    //   args: ['#dropzone', '#fileList']
    // }
  };
  
  export default helperRegistry;
  