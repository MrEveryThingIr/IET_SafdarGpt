export function toggle({ triggerSelector, targetSelector, className = 'hidden', eventType = 'click' }) {
    document.querySelectorAll(triggerSelector).forEach(trigger => {
      trigger.addEventListener(eventType, () => {
        const target = document.querySelector(targetSelector);
        if (target) target.classList.toggle(className);
      });
    });
  }
  