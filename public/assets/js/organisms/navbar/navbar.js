// public/assets/js/organisms/navbar/navbar.js

document.addEventListener('DOMContentLoaded', function() {
  const navbar = document.querySelector('.js-navbar');
  const toggles = document.querySelectorAll('.js-navbar-toggle');

  toggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
      const item = toggle.closest('.o-navbar__item--has-submenu');
      const submenu = item.querySelector('.js-navbar-submenu');
      submenu.classList.toggle('is-hidden');
    });
  });
});
