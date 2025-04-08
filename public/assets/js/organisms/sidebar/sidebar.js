// public/assets/js/organisms/sidebar/sidebar.js

document.addEventListener('DOMContentLoaded', () => {
  const toggles = document.querySelectorAll('.js-sidebar-toggle');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
      // The item with .o-sidebar__item--has-submenu
      const item = toggle.closest('.o-sidebar__item--has-submenu');
      const submenu = item.querySelector('.js-sidebar-submenu');

      // Toggle hidden class
      submenu.classList.toggle('hidden');

      // Optional: rotate arrow icon if desired
      // We can toggle a class on the item or the svg
      const svg = toggle.querySelector('svg');
      if (svg) {
        svg.classList.toggle('rotate-180');
      }
    });
  });
});
