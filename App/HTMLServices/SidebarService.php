<?php

namespace App\HTMLServices;

use App\HTMLRenderer\Sidebar;
use App\Models\User;

class SidebarService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function listAvailable(): array
{
    return list_json_components('sidebars');
}



    public function createDeveloperSidebar(): Sidebar
    {
        $user = $this->getAuthenticatedUser();

        $items = [
            [
                'type' => 'profile',
                'image' => base_url('assets/images/QuantomPhysicsPhpDeveloper.webp'),
                'name' => "{$user->firstname} {$user->lastname}",
                'balance' => '۰ تومان',
                'style' => 'profile-header',
            ],
            "Layout Settings" => [
                "Navbar" => '#',//route('gui.navbar.selectOrCreate'),
                "Sidebar" =>'#',// route('gui.sidebar.selectOrCreate'),
                "Attributes" =>'#',// route('gui.layout.attributes'),
            ],
            "Navbar" => [
                "Items" =>'#',// route('gui.navbar.items'),
                "Attributes" =>'#',// route('gui.navbar.attributes'),
            ],
            "Sidebar" => [
                "Items" =>'#',// route('gui.sidebar.items'),
                "Attributes" => '#',//route('gui.sidebar.attributes'),
            ],
            "Form" => [
                "Items" => '#',//route('gui.form.items'),
                "Attributes" => '#',//route('gui.form.attributes'),
            ],
            "Preview" => '#',//route('gui.preview')
        ];

        return new Sidebar([
            'items' => $items,
            'stylesPaths' => ['assets/css/organisms/sidebar/sidebar.css'],
            'scriptsPaths' => ['assets/js/organisms/sidebar/sidebar.js'],
        ]);
    }

    private function getAuthenticatedUser()
    {
        if (!isset($_SESSION['user_id'])) return null;
        $this->userModel->id = $_SESSION['user_id'];
        return $this->userModel->fetchUserById();
    }
}
