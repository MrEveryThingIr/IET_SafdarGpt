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
             $navbar =dashboardnavbar();
         $sidebar = isLoggedIn()?dashboardsidebar():null;

        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'اعلام عرضه یا تقاضا',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);

 
    }

    public function createChatRoomForm(){
        echo $this->render('chats/create_chatroom',[],[]);
    }

    public function allChatRooms(){
        $this->render('chats/all_chatrooms',[],[]);
    }
}