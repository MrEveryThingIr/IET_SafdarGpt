export function fadeIn({ targetSelector, duration = 300 }) {
    const el = document.querySelector(targetSelector);
    if (!el) return;
  
    el.style.opacity = 0;
    el.style.display = 'block';
    el.style.transition = `opacity ${duration}ms`;
  
    requestAnimationFrame(() => {
      el.style.opacity = 1;
    });
  }
  