// public/assets/js/organisms/navbar/navbar.js

document.addEventListener('DOMContentLoaded', () => {
  const toggles = document.querySelectorAll('.js-navbar-toggle');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', (e) => {
      e.stopPropagation(); // Prevent clicks from hiding it immediately if you have global listeners

      // The .o-navbar__item--has-submenu
      const item = toggle.closest('.o-navbar__item--has-submenu');
      const submenu = item.querySelector('.js-navbar-submenu');

      // Toggle hidden
      submenu.classList.toggle('hidden');

      // Optionally rotate arrow
      const svg = toggle.querySelector('svg');
      if (svg) {
        svg.classList.toggle('rotate-180');
      }
    });
  });

  // If you want to close any open dropdown by clicking outside:
  document.addEventListener('click', () => {
    const allSubmenus = document.querySelectorAll('.js-navbar-submenu:not(.hidden)');
    allSubmenus.forEach(submenu => {
      submenu.classList.add('hidden');
      // Also rotate arrow back if desired
      const parent = submenu.closest('.o-navbar__item--has-submenu');
      const svg = parent.querySelector('.js-navbar-toggle svg');
      if (svg) {
        svg.classList.remove('rotate-180');
      }
    });
  });
});
