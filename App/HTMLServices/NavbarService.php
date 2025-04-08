<?php
namespace App\HTMLServices;

use App\HTMLRenderer\Navbar;

class NavbarService
{
    /**
     * Create a "default" navbar
     */
    public function createDefaultNavbar(): Navbar
    {
        return new Navbar([
            'brand'        => 'MyApp',
            'items'        => [
                'Home'  => route('home'),
                'Login' => route('home.login'),
            ],
            'stylesPaths'  => ['assets/css/navbar_default.css'],
            'scriptsPaths' => ['assets/js/navbar_behavior.js'],
        ]);
    }

    /**
     * Create an "admin" navbar
     */
    public function createAdminNavbar(): Navbar
    {
        return new Navbar([
            'brand'        => 'Admin Panel',
            'items'        => [
                'Dashboard' => route('admin.dashboard'),
                'Users'     => route('admin.users'),
                'Reports'   => route('admin.reports'),
            ],
            'stylesPaths'  => ['assets/css/navbar_admin.css'],
            'scriptsPaths' => ['assets/js/navbar_admin.js'],
        ]);
    }

    /**
     * Create a minimal or "mobile" navbar, etc.
     */
    public function createMobileNavbar(): Navbar
    {
        return new Navbar([
            'brand'        => 'Mobile UI',
            'items'        => [],
            'stylesPaths'  => ['assets/css/navbar_mobile.css'],
            'scriptsPaths' => [],
        ]);
    }
}
