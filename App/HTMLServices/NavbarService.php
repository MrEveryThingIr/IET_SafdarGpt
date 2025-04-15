<?php

namespace App\HTMLServices;

use App\HTMLRenderer\Navbar;
use App\Models\User;

class NavbarService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function listAvailable(): array
{
    return list_json_components('navbars');
}


    public function createPublicNavbar(): Navbar
    {
        $items = [
            'ورود'    => route('home.login'),
            'ثبت‌نام' => route('home.register'),
        ];

        return new Navbar([
            'brand' => 'IET Platform',
            'items' => $items,
            'stylesPaths' => ['assets/css/organisms/navbar/navbar.css'],
            'scriptsPaths' => ['assets/js/organisms/navbar/navbar.js'],
        ]);
    }

    public function createAdminNavbar(): Navbar
    {
        $user = $this->getAuthenticatedUser();

        $items = [
            'خانه'    => route('dashboard.index'),
            'پروفایل' => route('user.profile'),
            'خروج'    => '__LOGOUT_FORM__',
        ];

        return new Navbar([
            'brand' => 'IET Admin Panel',
            'items' => $items,
            'stylesPaths' => ['assets/css/organisms/navbar/navbar.css'],
            'scriptsPaths' => ['assets/js/organisms/navbar/navbar.js'],
        ]);
    }

    public function createDeveloperNavbar(): Navbar
    {
        $items = [
            'Navbar' => [
                'Layout' => '#',
                'Items' => '#',
                'Styles' => '#',
                'Scripts' => '#',
            ],
            'Sidebar' => [
                'Layout' => '#',
                'Items' => '#',
                'Styles' => '#',
                'Scripts' => '#',
            ],
            'Form' => [
                'Layout' => '#',
                'Items' => '#',
                'Styles' => '#',
                'Scripts' => '#',
            ],
            'Preview' => '#'
        ];

        return new Navbar([
            'brand' => 'IET DeveloperInterface',
            'items' => $items,
            'stylesPaths' => ['assets/css/organisms/navbar/navbar.css'],
            'scriptsPaths' => ['assets/js/organisms/navbar/navbar.js'],
        ]);
    }

    private function getAuthenticatedUser()
    {
        if (!isset($_SESSION['user_id'])) return null;
        $this->userModel->id = $_SESSION['user_id'];
        return $this->userModel->fetchUserById();
    }
}
