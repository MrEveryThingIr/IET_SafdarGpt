// global.js

// DOM ready helper
function onDocumentReady(fn) {
    if (document.readyState !== 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }
  
  // Example usage:
  onDocumentReady(() => {
    console.log('Document ready - global.js loaded');
  });
  