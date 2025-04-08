// public/assets/js/organisms/sidebar/sidebar.js

document.addEventListener('DOMContentLoaded', function() {
  // Optional: if we want to do something with the entire sidebar
  const sidebar = document.querySelector('.js-sidebar');
  
  // We'll find all toggle buttons
  const toggles = document.querySelectorAll('.js-sidebar-toggle');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
      // The .js-sidebar-submenu is the next sibling or nested inside the same item
      const item = toggle.closest('.o-sidebar__item--has-submenu');
      const submenu = item.querySelector('.js-sidebar-submenu');
      // Toggle .is-hidden
      submenu.classList.toggle('is-hidden');
    });
  });
});
