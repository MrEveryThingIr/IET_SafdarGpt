export function applyTransition({ selector, transition = 'all 300ms ease' }) {
    const el = document.querySelector(selector);
    if (el) el.style.transition = transition;
  }
  