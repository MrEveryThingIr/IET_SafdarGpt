export function accordion(config) {
  const {
    selector = '.accordion-item',
    headerClass = '.accordion-header',
    bodyClass = '.accordion-body',
    collapseOthers = false,
    animation = { type: null, duration: 300 },
    lifecycle = {}
  } = config;

  const items = document.querySelectorAll(selector);

  items.forEach(item => {
    const header = item.querySelector(headerClass);
    const body = item.querySelector(bodyClass);
    if (!header || !body) return;

    header.addEventListener('click', () => {
      const isOpen = !body.classList.contains('hidden');

      if (collapseOthers) {
        document.querySelectorAll(bodyClass).forEach(b => {
          if (b !== body) b.classList.add('hidden');
        });
      }

      if (!isOpen) {
        body.classList.remove('hidden');
        lifecycle.afterOpen?.(body);
      } else {
        body.classList.add('hidden');
        lifecycle.afterClose?.(body);
      }
    });
  });
}
