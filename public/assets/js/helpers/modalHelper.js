export function initModalGroup(triggerModalPairs, options = {}) {
  triggerModalPairs.forEach(([trigger, modal]) => {
    modalHelper(trigger, modal, options);
  });
}

export default function modalHelper(triggerSelector, modalSelector, options = {}) {
  const config = {
    loginRoute: window._AUTH_STATE.loginRoute,
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

  // 👇 Determine the best event type
  const eventType = window.ontouchstart !== undefined ? 'touchstart' : 'click';

  // 👇 Trigger open
  trigger.addEventListener(eventType, (e) => {
    e.preventDefault();
    console.log(`🟢 Opening modal: ${modalSelector}`);
    if (window._AUTH_STATE.isLoggedIn) {
      modal.classList.remove(config.hiddenClass);
      modal.classList.add(config.visibleClass);
    } else {
      window.location.href = config.loginRoute;
    }
  });

  // 👇 Close button inside modal
  const closeBtn = modal.querySelector(config.closeSelector);
  if (closeBtn) {
    closeBtn.addEventListener(eventType, (e) => {
      e.preventDefault();
      modal.classList.add(config.hiddenClass);
      modal.classList.remove(config.visibleClass);
    });
  }

  // 👇 Clicking on modal backdrop closes it
  modal.addEventListener(eventType, (e) => {
    if (e.target === modal) {
      modal.classList.add(config.hiddenClass);
      modal.classList.remove(config.visibleClass);
    }
  });
}
