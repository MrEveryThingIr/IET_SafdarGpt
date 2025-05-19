export function initModalGroup(triggerModalPairs, options = {}) {
  triggerModalPairs.forEach(([trigger, modal]) => {
    modalHelper(trigger, modal, options);
  });
}

export default function modalHelper(triggerSelector, modalSelector, options = {}) {
  const config = {
    loginRoute: _AUTH_STATE.loginRoute,
    hiddenClass: 'hidden',
    visibleClass: 'block',
    closeSelector: '.close-button',
    ...options
  };

  const trigger = document.querySelector(triggerSelector);
  const modal = document.querySelector(modalSelector);

  if (!trigger || !modal) {
    console.log('🔍 Trying to register modal:', { triggerSelector, modalSelector, trigger, modal });

    return;
  }

  trigger.addEventListener('click', (e) => {
    e.preventDefault();
    if (window._AUTH_STATE.isLoggedIn) {
      modal.classList.remove(config.hiddenClass);
      modal.classList.add(config.visibleClass);
    } else {
      window.location.href = config.loginRoute;
    }
  });

  const closeBtn = modal.querySelector(config.closeSelector);
  if (closeBtn) {
    closeBtn.addEventListener('click', (e) => {
      e.preventDefault();
      modal.classList.add(config.hiddenClass);
      modal.classList.remove(config.visibleClass);
    });
  }

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.add(config.hiddenClass);
      modal.classList.remove(config.visibleClass);
    }
  });
}
