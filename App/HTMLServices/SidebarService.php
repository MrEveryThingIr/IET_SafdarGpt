<?php
namespace App\HTMLServices;

use App\HTMLRenderer\Sidebar;

class SidebarService
{
    /**
     * Create a default sidebar
     */
    public function createDefaultSidebar(): Sidebar
    {
        return new Sidebar([
            'items'        => ['Dashboard'=>"#", 'Settings'=>'#', 'Help'=>'#'],
            'stylesPaths'  => ['assets/css/organisms/sidebar/sidebar.css'],
            'scriptsPaths' => ['assets/js/organisms/sidebar/sidebar.js'],
        ]);
    }

    /**
     * Create an admin sidebar
     */public function createAdminSidebar(): Sidebar
{
    $items = [
        'Dashboard' => '#',
        'Categories' => [
            'Create Category' => '#',
            'List Categories' => '#',
            'Advanced' => [
                'SubCat A' => '#',
                'SubCat B' => '#',
            ],
        ],
        'Transactions' => [
            'Create' => '#',
            'List' => '#',
        ],
    ];

    return new Sidebar([
        'items' => $items,
        'stylesPaths' => [
            // Only load the relevant CSS
            'assets/css/organisms/sidebar/sidebar.css'
        ],
        'scriptsPaths' => [
            // Only load the relevant JS
            'assets/js/organisms/sidebar/sidebar.js'
        ],
    ]);
}



    /**
     * Create a minimal or mobile sidebar, etc.
     */
    public function createMobileSidebar(): Sidebar
    {
        return new Sidebar([
            'items'        => ['Profile', 'Messages'],
            'stylesPaths'  => ['assets/css/sidebar_mobile.css'],
            'scriptsPaths' => [],
        ]);
    }
}
