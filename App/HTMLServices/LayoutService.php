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
        // In a more advanced setup, you might pass these in via DI.
        $this->navbarService  = new NavbarService();
        $this->sidebarService = new SidebarService();
    }

    /**
     * Create a default layout (default navbar & sidebar).
     */
    public function createDefaultLayout(): Layout
    {
        $navbar = $this->navbarService->createDefaultNavbar();
        $sidebar = $this->sidebarService->createDefaultSidebar();

        return new Layout($navbar, $sidebar, [
            'title'       => 'Default Page',
            'stylesPaths' => ['assets/css/global/layout.css',],
            'scriptsPaths'=> ['assets/js/global/utils.js'],
            // 'layoutView' => 'layout' // if you want a non-default layout file
        ]);
    }

    /**
     * Create an admin layout.
     */
    public function createAdminLayout(): Layout
    {
        $navbar = $this->navbarService->createAdminNavbar();
        $sidebar = $this->sidebarService->createAdminSidebar();
        
        return new Layout($navbar, $sidebar, [
          'title'       => 'Admin Panel',
          'stylesPaths' => ['assets/css/global/layout.css',],
          'scriptsPaths'=> ['assets/js/global/utils.js'],
        ]);
        
    }

    /**
     * Create a "mobile" layout (or minimal layout).
     */
    public function createMobileLayout(): Layout
    {
        $navbar = $this->navbarService->createMobileNavbar();
        $sidebar = $this->sidebarService->createMobileSidebar();

        return new Layout($navbar, $sidebar, [
            'title'       => 'Mobile UI',
            'stylesPaths' => ['assets/css/layout_mobile.css'],
            'scriptsPaths'=> ['assets/js/layout_mobile.js'],
        ]);
    }

    /**
     * Or an ad-hoc method that allows picking any existing Nav/Sidebar
     * if you want maximum flexibility in controllers:
     */
    public function createCustomLayout(?Navbar $navbar, ?Sidebar $sidebar, array $options = []): Layout
    {
        return new Layout($navbar, $sidebar, $options);
    }
}
