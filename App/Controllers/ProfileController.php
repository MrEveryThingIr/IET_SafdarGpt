<?php 
namespace App\Controllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\Models\IETAnnounce;
use App\Models\User;

class ProfileController extends BaseController
{
    public function __construct(){
        isLoggedIn();


        $this->layout = new Layout($navbar=null, $sidebar=null, [
            'title' => 'پروفایل',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);
    }
    public function center($feature){
        $data=[];
        
        switch ($feature){
            case 'identification':
                $user=new User();
                $user->id=1;
                $data['user_info']=$user->fetchUserById();
                $data['userAge']=$user->getUserAge(1);
                break;
            case 'my_announces':
                $data=(new IETAnnounce())->getByUser(1);
                break;
            case 'education_and_honors':
                $data=[];
                break;
        }
        
        
        $this->render('auth/profile/center',['feature'=>$feature,'data'=>$data],[]);
    }
}