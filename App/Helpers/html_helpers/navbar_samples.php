<?php

use App\HTMLRenderer\Navbar;
function dashboardnavbar(): Navbar {
    $user = currentUser();

    $navbar = [];
    $navbar = add_navbar_brand($navbar, 'Dashboard', route('dashboard'), 'text-2xl font-bold text-white');
    $navbar = add_navbar_user_profile($navbar, $user);
    $navbar = add_navbar_item($navbar, 'داشبورد', route('dashboard'), 'bg-green-700 text-white px-4 py-2 rounded-md');
    $navbar = add_navbar_form_button($navbar, 'خروج', route('auth.logout'), 'POST', 'bg-red-600 text-white px-4 py-2 rounded-md');

    return new Navbar($navbar);
}

function home_navbar(): Navbar {
    $navbar = [];

    $navbar = add_navbar_brand($navbar, 'IET Home', route('iethome'), 'text-2xl font-bold text-gray-800 hover:text-blue-600');
    $navbar = add_navbar_item($navbar, 'معرفی', route('iethome'), 'px-4 py-2 text-lg font-medium text-gray-700 hover:text-blue-600');
    $navbar = add_navbar_item($navbar, 'اعلام‌ها', route('ietannounce.all'), 'px-4 py-2 text-lg font-medium text-gray-700 hover:text-blue-600');

    if (!isLoggedIn()) {
        $navbar = add_navbar_item($navbar, 'عضویت', route('auth.register'), 'text-gray-700 hover:text-blue-600 px-3 py-2');
        $navbar = add_navbar_item($navbar, 'وارد شوید', route('auth.login'), 'bg-green-700 text-white px-4 py-2 rounded-md');
    } else {
        $user = currentUser();
        $navbar = add_navbar_user_profile($navbar, $user);
        $navbar = add_navbar_form_button($navbar, 'خروج', route('auth.logout'), 'POST', 'bg-red-600 text-white px-4 py-2 rounded-md');
    }

    return new Navbar($navbar);
}

function admin_navbar(): Navbar {
    $user = currentUser();

    $navbar = [];
    $navbar = add_navbar_brand($navbar, 'Admin Panel', route('dashboard'), 'text-2xl font-bold text-white');
    $navbar = add_navbar_item($navbar, 'Users','#', 'text-white px-4 py-2');
    $navbar = add_navbar_item($navbar, 'Settings','#', 'text-white px-4 py-2');
    $navbar = add_navbar_user_profile($navbar, $user, '');
    $navbar = add_navbar_form_button($navbar, 'Log out', route('auth.logout'), 'POST', 'bg-red-600 text-white px-4 py-2 rounded-md');

    $navbar = navbar_dark_theme($navbar);
    return new Navbar($navbar);
}
