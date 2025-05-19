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
    existingMedia: {
      module: '/assets/js/helpers/filePreviewer.js',
      method: 'initExistingMediaPreviewer',
      args: [window._EXISTING_MEDIA || [], '#existingMediaContainer']
    },
    mediaUploader: {
      module: '/assets/js/helpers/mediaUploader.js',
      method: 'initMediaUploader',
      args: ['#mediaUploaderInput', '#uploadedMediaList', { accept: ['image/*', 'video/*', 'audio/*'], multiple: true }]
    },

    modal: {
      module: '/assets/js/helpers/modalHelper.js',
      method: 'initAuthModal',
      args: ['#trigger', '#target_modal', {
          loginRoute: '/login',
          hiddenClass: 'hidden',
          visibleClass: 'block',
          closeSelector: '.close'
      }]
  },

    modalTriggers: {
    module: '/assets/js/helpers/modalHelper.js',
    method: 'initModalGroup',
    args: [
      [
        ['#trigger_addParagraphModal', '#addParagraphModal'],
        ['#trigger_addHeadingModal', '#addHeadingModal'],
        ['#trigger_addImageModal', '#addImageModal'],
        ['#trigger_addAudioModal', '#addAudioModal'],
        ['#trigger_addVideoModal', '#addVideoModal'],
        ['#trigger_addListModal', '#addListModal'],
        ['#trigger_addQuoteModal', '#addQuoteModal'],
        ['#trigger_addDividerModal', '#addDividerModal'],
        ['#trigger_addEmbedModal', '#addEmbedModal'],
        ['#trigger_addCtaModal', '#addCtaModal'],
        ['#trigger_addFaqModal', '#addFaqModal'],
        ['#trigger_addSectionModal', '#addSectionModal']
      ],
      {
        loginRoute: '/login',
        hiddenClass: 'hidden',
        visibleClass: 'block',
        closeSelector: '.close-button'
      }
    ]
  }
  };
  
  export default helperRegistry;
  