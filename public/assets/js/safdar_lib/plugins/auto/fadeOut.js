export function fadeOut({ targetSelector, duration = 300 }) {
  const el = document.querySelector(targetSelector);
  if (!el) return;

  el.style.opacity = 1;
  el.style.transition = `opacity ${duration}ms`;
  el.style.opacity = 0;

  setTimeout(() => {
    el.style.display = 'none';
  }, duration);
}
