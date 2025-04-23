export function watchDomChange(selector, callback) {
    const target = document.querySelector(selector);
    if (!target) return;
  
    const observer = new MutationObserver(callback);
    observer.observe(target, { childList: true, subtree: true });
  }
  