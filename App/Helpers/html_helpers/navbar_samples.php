<?php

use App\HTMLRenderer\Navbar;
function dashboardnavbar(): Navbar {
    
    
    
    if(isLoggedIn()){
        $user = currentUser();
        $navbar = [];
        $navbar = add_navbar_brand($navbar, 'Dashboard', route('dashboard'), 'text-2xl font-bold text-black');
        $navbar = add_navbar_user_profile($navbar, $user);
        $navbar = add_navbar_item($navbar, 'خانه', route('iethome'), 'bg-blue-500 text-white px-4 py-2 rounded-md');
        $navbar = add_navbar_form_button($navbar, 'خروج', route('auth.logout'), 'POST', 'bg-red-600 text-white px-4 py-2 rounded-md');

    return new Navbar($navbar);
    }else{
        return home_navbar(); 
    }
    

  
}

function secondnavbar($label_routes=[]): Navbar {

    $navbar = [];
    foreach($label_routes as $label=>$route){
            $navbar = add_navbar_item($navbar, $label, $route, 'bg-black text-white m-3 px-4 py-2 rounded-md');
    }
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
        $navbar = add_navbar_item($navbar, 'داشبورد', route('dashboard'), 'px-4 py-2 text-lg font-medium text-gray-700 hover:text-blue-600');
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



function categories_and_supply_navbar(): Navbar {
    $navbar = [];

    // Brand
    $navbar = add_navbar_brand(
        $navbar,
        'همه چیز',
        route('ietannounce.all', ['filter' => '']),
        'px-4 py-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-md font-bold hover:from-indigo-600 hover:to-pink-600 transition-all duration-300'
    );

    // Category items
    $category_items = [
        ['label' => 'املاک و مسکن', 'filter' => 'housing'],
        ['label' => 'غذا و خوراکی', 'filter' => 'food'],
        ['label' => 'لباس و پوشاک', 'filter' => 'wear'],
        ['label' => 'حمل و نقل', 'filter' => 'transportation'],
        ['label' => 'آموزشی', 'filter' => 'education'],
    ];
    foreach ($category_items as $item) {
        $navbar = add_navbar_item(
            $navbar,
            $item['label'],
            route('ietannounce.filtered', ['filter' => $item['filter']]),
            'px-4 py-2 bg-yellow-300 border border-gray-300 text-gray-800 rounded-md font-medium shadow-sm hover:bg-blue-50 transition'
        );
    }

    // Separator item (visual distinction)
    $navbar = add_navbar_item($navbar, '|', '#', 'pointer-events-none opacity-50 px-2');

    // Supply/Demand items
    $supply_items = [
        ['label' => 'عرضه', 'filter' => 'supply', 'color' => 'blue'],
        ['label' => 'تقاضا', 'filter' => 'demand', 'color' => 'blue'],
        ['label' => 'خدمات', 'filter' => 'services', 'color' => 'green'],
        ['label' => 'کالا', 'filter' => 'goods', 'color' => 'green'],
    ];
    foreach ($supply_items as $item) {
        $navbar = add_navbar_item(
            $navbar,
            $item['label'],
            route('ietannounce.filtered', ['filter' => $item['filter']]),
            'px-4 py-2 bg-' . $item['color'] . '-600 text-white rounded-md font-semibold hover:bg-' . $item['color'] . '-700 transition'
        );
    }

    return new Navbar($navbar);
}
