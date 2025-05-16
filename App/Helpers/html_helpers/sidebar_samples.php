<?php
use App\HTMLRenderer\Sidebar;

function dashboardsidebar(): Sidebar {
    $sidebar = [];

    $user = currentUser();

    $sidebar = sidebar_add_header(
        $sidebar,
        $user,
        $user['balance'] ?? '0',
        $user['bio'] ?? 'همه چیز برای همه، همه برای هم',
        'mb-4 p-4 bg-blue-100 rounded text-gray-800'
    );

    $sidebar = sidebar_add_item($sidebar, 'اعلام ها', null, route('ietannounce.all'), '', '📊', true);
    $sidebar = sidebar_add_item($sidebar, 'مقاله ها', null, '#', '', '📈');
    $sidebar = sidebar_add_item($sidebar, 'گروهها و گفتگوها', null, route('ietchats.room.all'), '', '⚙️');
    if($user['username']=='SMSchrodinger'){
         $sidebar = sidebar_add_item($sidebar, 'دسته بندیها', null, route('ietcategories.all'), '');
    }
 

    $sidebar = sidebar_set_style($sidebar, 'w-64 bg-blue-400 text-white h-full p-4');

    return new Sidebar($sidebar);
}

function home_sidebar(): Sidebar {
    $sidebar = [];

    if (isLoggedIn()) {
        $user = currentUser();
        $sidebar = sidebar_add_header($sidebar, $user, $user['balance'] ?? '0', $user['bio'] ?? '');
        $sidebar = sidebar_add_item($sidebar, 'Profile', null, '#', '', '👤');
        $sidebar = sidebar_add_item($sidebar, 'Logout', null, '#', 'text-red-400 hover:bg-red-800', '🚪');
    } else {
        $sidebar = sidebar_add_item($sidebar, 'Login', null, '#', 'bg-green-700 text-white', '🔐', true);
        $sidebar = sidebar_add_item($sidebar, 'Register', null, '#', '', '📝');
    }

    $sidebar = sidebar_add_item($sidebar, 'Home', null, '#', '', '🏠');
    $sidebar = sidebar_add_item($sidebar, 'About', null, '#', '', 'ℹ️');

    $sidebar = sidebar_set_style($sidebar, 'w-64 bg-gray-800 text-white p-4');

    return new Sidebar($sidebar);
}


function admin_sidebar(): Sidebar {
    $sidebar = [];

    $user = currentUser();
    $sidebar = sidebar_add_header($sidebar, $user, '∞', 'Administrator');

    $sidebar = sidebar_add_item($sidebar, 'Dashboard', null, '#', '', '🧭', true);
    $sidebar = sidebar_add_item($sidebar, 'Users', null, '#', '', '👥');
    $sidebar = sidebar_add_item($sidebar, 'Logs', null, '#', '', '📜');
    $sidebar = sidebar_add_item($sidebar, 'Settings', null, '#', '', '⚙️');
    $sidebar = sidebar_add_item($sidebar, 'Logout', null, '#', 'text-red-400 hover:bg-red-800', '🚪');

    $sidebar = sidebar_set_style($sidebar, 'w-64 bg-gray-950 text-white p-4');

    return new Sidebar($sidebar);
}

