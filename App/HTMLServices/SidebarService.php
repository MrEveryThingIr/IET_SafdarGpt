<?php
namespace App\HTMLServices;

use App\HTMLRenderer\Sidebar;
use App\Models\User;

class SidebarService
{
    private $userModel;
    public function __construct() {
        $this->userModel=new User();
    }
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
     */


    public function createAdminSidebar(): Sidebar
    {
        $this->userModel->id=$_SESSION['user_id'];
        $user=$this->userModel->fetchUserById();
      
        
        $items = [
            [
                'type' => 'profile',
                'image' => uploads_url($user->img ?? 'default.png'),
                'name' => "{$user->firstname} {$user->lastname}",
                'balance' => '۰ تومان', // Later replace with dynamic balance
                'style' => 'profile-header', // custom styling class
            ],
            'تراکنش ها' => '#',
            'برنامه ریزی و کنترل زمان' =>route('planner.calendar'),
            'ایجاد برنامه جدید' => [
                'برنامه سفر' =>'#',
                'برنامه مهمانی، جشن، مراسم' => '#',
                'دعوت به مشارکت، همکاری و استخدام' =>'#',
            ],
            'ثبت اطلاعات شخصی من' => '#',
        ];
    
        return new Sidebar([
            'items' => $items,
            'stylesPaths' => [
                'assets/css/organisms/sidebar/sidebar.css',
               
            ],
            'scriptsPaths' => [
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
