export function slideToggle(el, duration = 300) {
    if (window.getComputedStyle(el).display === 'none') {
      el.style.display = 'block';
      el.style.height = '0px';
      el.style.overflow = 'hidden';
      el.style.transition = `height ${duration}ms`;
  
      requestAnimationFrame(() => {
        el.style.height = el.scrollHeight + 'px';
      });
  
      setTimeout(() => {
        el.style.height = '';
      }, duration);
    } else {
      el.style.height = el.scrollHeight + 'px';
      requestAnimationFrame(() => {
        el.style.height = '0px';
      });
  
      setTimeout(() => {
        el.style.display = 'none';
        el.style.height = '';
      }, duration);
    }
  }
  