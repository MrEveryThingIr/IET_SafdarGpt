<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\IETAnnounceComment;
use App\HTMLRenderer\Layout;

use function App\Helpers\clean;

class IETAnnounceCommentController extends BaseController
{
    private $commentModel;
    public function __construct(){
        $this->commentModel=new IETAnnounceComment();
    }
    public function addCommentOnAnnounce($announce_id){
        
        $this->render('iet_announce/comments/create',['announce_id'=>$announce_id]);
    }

    public function storeComment($announce_id){
        $comment= nl2br(htmlspecialchars(trim($_POST['comment_on_announce'] ?? ''), ENT_QUOTES, 'UTF-8'));
        $data=['announce_id'=>$announce_id,'commentor_id'=>1,'comment'=>$comment];
        if($this->commentModel->create($data)){
            $_SESSION['success']='کامنت افزوده شد';
        }else{
            $_SESSION['error']='کامنت ارسال نشد';
        };
        redirect(route('ietannounce.show',['id'=>$announce_id]));
    }
}