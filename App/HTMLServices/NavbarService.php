<?php
namespace App\HTMLServices;

use App\HTMLRenderer\Navbar;
use App\Models\User;
class NavbarService
{
    private $userModel;
    public function __construct() {
        $this->userModel=new User();
    }
    /**
     * Create a "default" navbar
     */
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
        if(isset($_SESSION['user_id'])){
            $user=$this->userModel->fetchUserById();
        };
        $items =[
            'خانه'    => route('dashboard.index'),
            'پروفایل' => route('user.profile'),
            'خروج'    => '__LOGOUT_FORM__', // <--- triggers form rendering
        ];
        
    
        return new Navbar([
            'brand' => 'IET Platform',
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
