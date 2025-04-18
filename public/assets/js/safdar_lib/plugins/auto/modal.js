export function modal({ openSelector, closeSelector, modalSelector }) {
    const openBtn = document.querySelector(openSelector);
    const closeBtn = document.querySelector(closeSelector);
    const modal = document.querySelector(modalSelector);
  
    if (!openBtn || !modal) return;
  
    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    if (closeBtn) closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
  }
  