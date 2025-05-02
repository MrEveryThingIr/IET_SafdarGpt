/**
 * Initialize <name> feature
 *
 * @param {string} targetSelector - DOM selector to attach behavior
 * @param {Object} options - Optional config
 */
export function initFeatureTemplate(targetSelector, options = {}) {
    const target = document.querySelector(targetSelector);
    if (!target) {
      console.warn(`[featureTemplate] No element found for selector: ${targetSelector}`);
      return;
    }
  
    // Example usage
    console.log('Initializing feature template on', target, 'with options:', options);
  }
  