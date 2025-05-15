<?php

namespace App\Controllers;

use App\HTMLRenderer\Navbar;
use App\Core\BaseController;
use App\Services\ChatService;
use App\HTMLRenderer\Layout;

use function Data\Navbars\admin_navbar;

class ChatController extends BaseController
{
   
    private $chatServices;
    public function __construct(){
        $this->chatServices=new ChatService();
 
    }

    public function createChatRoomForm(){

        
        
        $navbar=dashboardnavbar();


        $sidebar = admin_sidebar();
       
        $this->layout = new Layout($navbar, $sidebar , [
            'title' => 'تالارهای گفتگو',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => []
        ]);
        echo $this->render('chats/create_chatroom',[],[]);
        // var_dump($navbar);
    }
}