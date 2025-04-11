document.addEventListener('DOMContentLoaded', () => {
  const toggles = document.querySelectorAll('.js-sidebar-toggle');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
      const currentItem = toggle.closest('.o-sidebar__item--has-submenu');
      const currentSubmenu = currentItem.querySelector('.js-sidebar-submenu');
      const currentIcon = toggle.querySelector('svg');

      // Close other open submenus
      document.querySelectorAll('.js-sidebar-submenu').forEach(menu => {
        if (menu !== currentSubmenu) menu.classList.add('hidden');
      });

      document.querySelectorAll('.js-sidebar-toggle svg').forEach(icon => {
        if (icon !== currentIcon) icon.classList.remove('rotate-180');
      });

      // Toggle current submenu and icon
      currentSubmenu.classList.toggle('hidden');
      currentIcon.classList.toggle('rotate-180');
    });
  });
});
