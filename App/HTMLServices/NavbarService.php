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
            'stylesPaths'  => ['assets/css/organisms/navbar/navbar.css'],
            'scriptsPaths' => ['assets/js/organisms/navbar/navbar.js'],
        ]);
    }

    public function createAdminNavbar(): Navbar
    {
        $items = [
            'Home' => route('home'),
            'Services' => [
                'SubService1' => "#",
                'SubService2' => '#',
                'More' => [
                    'SubSub1' => '#',
                    'SubSub2' => "#",
                ],
            ],
            'Contact' => "#",
        ];
    
        return new Navbar([
            'brand' => 'Admin Panel',
            'items' => $items,
            'stylesPaths' => [
                'assets/css/organisms/navbar/navbar.css'
            ],
            'scriptsPaths' => [
                'assets/js/organisms/navbar/navbar.js'
            ],
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
