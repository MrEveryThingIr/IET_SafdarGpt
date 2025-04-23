export function dropdown(config) {
  const {
    triggerSelector,
    dropdownSelector,
    eventType = 'click',
    closeOnOutsideClick = true,
    activeClass = 'open',
    hideClass = 'hidden',
    preventDefault = false,
    animation = { type: null, duration: 300 },
    lifecycle = {}
  } = config;

  const trigger = document.querySelector(triggerSelector);
  const dropdown = document.querySelector(dropdownSelector);
  if (!trigger || !dropdown) return;

  trigger.addEventListener(eventType, (e) => {
    if (preventDefault) e.preventDefault();
    lifecycle.beforeOpen?.(trigger, dropdown);

    dropdown.classList.toggle(hideClass);
    dropdown.classList.toggle(activeClass);

    if (animation.type === 'fade') {
      dropdown.style.transition = `opacity ${animation.duration}ms`;
      dropdown.style.opacity = dropdown.classList.contains(hideClass) ? 0 : 1;
    }

    lifecycle.afterOpen?.(trigger, dropdown);
  });

  if (closeOnOutsideClick) {
    document.addEventListener('click', (e) => {
      if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
        dropdown.classList.add(hideClass);
        dropdown.classList.remove(activeClass);
        lifecycle.afterClose?.(dropdown);
      }
    });
  }
}
