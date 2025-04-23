export function tooltip(config) {
  const {
    triggerSelector = '[data-tooltip]',
    eventType = 'hover',
    delay = 0,
    placement = 'bottom',
    theme = 'dark',
    lifecycle = {},
    customContentCallback
  } = config;

  const triggers = document.querySelectorAll(triggerSelector);

  triggers.forEach(trigger => {
    const tooltipText = trigger.getAttribute('data-tooltip');
    if (!tooltipText) return;

    const tooltip = document.createElement('div');
    tooltip.className = `tooltip hidden absolute z-50 px-2 py-1 text-xs rounded bg-black text-white ${theme}`;
    tooltip.innerText = tooltipText;
    document.body.appendChild(tooltip);

    const show = () => {
      if (customContentCallback) {
        tooltip.innerHTML = customContentCallback(trigger) || tooltipText;
      }

      tooltip.classList.remove('hidden');
      const rect = trigger.getBoundingClientRect();

      if (placement === 'bottom') {
        tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;
        tooltip.style.left = `${rect.left + window.scrollX}px`;
      }

      lifecycle.afterOpen?.(tooltip, trigger);
    };

    const hide = () => {
      setTimeout(() => {
        tooltip.classList.add('hidden');
        lifecycle.afterClose?.(tooltip, trigger);
      }, delay);
    };

    if (eventType === 'hover') {
      trigger.addEventListener('mouseenter', show);
      trigger.addEventListener('mouseleave', hide);
    } else {
      trigger.addEventListener('click', () => {
        tooltip.classList.toggle('hidden');
        show();
      });
    }
  });
}
