<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Services\ChatService;
use App\HTMLRenderer\Layout;


class ChatController extends BaseController
{
    private $chatServices;
    public function __construct(){
        $this->chatServices=new ChatService();
        $this->layout = new Layout($navbar=null, $sidebar = null, [
            'title' => 'تالارهای گفتگو',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => []
        ]);
    }

    public function createChatRoomForm(){
        $this->render('chats/create_chatroom',[],[]);
    }
}