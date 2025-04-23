export function modal(config) {
  const {
    openSelector,
    closeSelector,
    modalSelector,
    backdrop = true,
    closeOnEscape = true,
    animation = { type: 'fade', duration: 300 },
    lifecycle = {}
  } = config;

  const openBtn = document.querySelector(openSelector);
  const closeBtn = document.querySelector(closeSelector);
  const modal = document.querySelector(modalSelector);
  if (!openBtn || !modal) return;

  let backdropEl;

  openBtn.addEventListener('click', () => {
    lifecycle.beforeOpen?.(modal);
    modal.classList.remove('hidden');
    if (animation.type === 'fade') {
      modal.style.transition = `opacity ${animation.duration}ms`;
      modal.style.opacity = 1;
    }
    if (backdrop) {
      backdropEl = document.createElement('div');
      backdropEl.className = 'fixed inset-0 bg-black opacity-50 z-40';
      document.body.appendChild(backdropEl);
    }
    lifecycle.afterOpen?.(modal);
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      modal.classList.add('hidden');
      if (backdropEl) backdropEl.remove();
      lifecycle.afterClose?.(modal);
    });
  }

  if (closeOnEscape) {
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        modal.classList.add('hidden');
        if (backdropEl) backdropEl.remove();
        lifecycle.afterClose?.(modal);
      }
    });
  }
}
