<?php

namespace App\HTMLServices;

use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;

class LayoutService
{
    private NavbarService $navbarService;
    private SidebarService $sidebarService;

    public function __construct()
    {
        $this->navbarService  = new NavbarService();
        $this->sidebarService = new SidebarService();
    }

    public function createPublicLayout(): Layout
    {
        $navbar = $this->navbarService->createPublicNavbar();
        return new Layout($navbar, null, [
            'title' => 'Welcome',
            'stylesPaths' => [
                'assets/css/global/layout.css',
                'assets/css/organisms/navbar/navbar.css',
            ],
            'scriptsPaths' => [
                'assets/js/global/utils.js',
                'assets/js/organisms/navbar/navbar.js',
            ],
        ]);
    }


    public function createDeveloperLayout(): Layout
    {
        $navbar = $this->navbarService->createAdminNavbar();
        $sidebar = $this->sidebarService->createDeveloperSidebar();

        return new Layout($navbar, $sidebar, [
            'title' => 'IET Developer GUI',
            'stylesPaths' => ['assets/css/global/layout.css'],
            'scriptsPaths' => ['assets/js/global/utils.js'],
        ]);
    }

    public function createCustomLayout(?Navbar $navbar, ?Sidebar $sidebar, array $options = []): Layout
    {
        return new Layout($navbar, $sidebar, $options);
    }
}
