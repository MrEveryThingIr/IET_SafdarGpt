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
            'items'        => ['Dashboard', 'Settings', 'Help'],
            'stylesPaths'  => ['assets/css/sidebar_default.css'],
            'scriptsPaths' => [],
        ]);
    }

    /**
     * Create an admin sidebar
     */
    public function createAdminSidebar(): Sidebar
    {
        return new Sidebar([
            'items'        => ['Admin Home', 'System Logs', 'Server Config'],
            'stylesPaths'  => ['assets/css/sidebar_admin.css'],
            'scriptsPaths' => [],
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
