<?php

namespace App\Controllers;

use App\HTMLRenderer\Navbar;
use App\Core\BaseController;
use App\Models\User;
use App\Services\ChatService;
use App\HTMLRenderer\Layout;

use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Services\CategoryService;

use function Data\Navbars\admin_navbar;

class ChatController extends BaseController
{
    private $userModel;
    private $chatServices;

    private $mainCategoryModel;
    private $subCategoryModel;
    private $categoryService;
    public function __construct(){
        $this->userModel=new User();
        $this->chatServices=new ChatService();

        $this->mainCategoryModel=new MainCategory();
        $this->subCategoryModel=new SubCategory();
        $this->categoryService=new CategoryService($this->mainCategoryModel,        $this->subCategoryModel);
             $navbar =dashboardnavbar();
         $sidebar = isLoggedIn()?dashboardsidebar():null;

        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'اعلام عرضه یا تقاضا',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);

 
    }

    public function allChatRooms(){

        $categories=$this->categoryService->getAllSubCategories();
        $chatRooms=$this->chatServices->listRooms();
        
        $this->render('chats/all_chatrooms',['categories'=>$categories,'rooms'=>$chatRooms],[]);
    }

    public function  showChatRoom($id) {
        $members=$this->chatServices->getInviteesByRoom($id);
        $sidebar=chatroomSidebar($members);
        $navbar =dashboardnavbar();
         

        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'اعلام عرضه یا تقاضا',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);
        $chatRoom=$this->chatServices->getRoomById($id);
        
        $usersList=$this->userModel->all_records('users');
        $categories=$this->categoryService->getAllSubCategories();
        $chats=$this->chatServices->listMessages();
        $this->render('chats/show_chatroom',['chats'=>$chats,'categories'=>$categories,'room'=>$chatRoom,'members'=>$members,'all_users'=>$usersList],[]);
    }

public function storeChatRoom() {
    // Verify POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'Invalid request method';
        redirect(route('ietchats.room.all')); // Adjust route name as needed
        return;
    }

    // CSRF protection
    if (!isset($_POST['_token']) || !csrf('verify', $_POST['_token'])) {
        $_SESSION['error'] = 'Invalid security token';
        redirect(route('ietchats.room.all')); // Adjust route name as needed
        return;
    }

    // Validate required fields
    $requiredFields = ['title', 'creator_id']; // Adjust fields as needed
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error'] = "Required field '$field' is missing";
            redirect(route('ietchats.room.all')); // Adjust route name as needed
            return;
        }
    }

    try {
        // Prepare data - adjust fields according to your needs
        $roomData = [
            'title' => $_POST['title'],
            'category_id' => $_POST['category_id'],
            'description' => $_POST['description'] ?? null,
            'creator_id' => user()['id'] // Assuming you have auth helper
        ];

        // Create the room
        $room_id = $this->chatServices->createRoom($roomData);
        
        if ($room_id) {
            $_SESSION['success'] = 'Chat room created successfully';
            redirect(route('ietchats.room.all', ['id' => $room_id])); // Adjust route name as needed
        } else {
            $_SESSION['error'] = 'Failed to create chat room';
            redirect(route('ietchats.room.all')); // Adjust route name as needed
        }
        
    } catch (\Exception $e) {
        $_SESSION['error'] = 'Error creating chat room: ' . $e->getMessage();
        redirect(route('ietchats.room.all')); // Adjust route name as needed
    }
}

public function inviteUserToChatRoom()
{
    // Ensure request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'درخواست نامعتبر است.';
        redirect(route('ietchats.room.show', ['id' => $_POST['to_chatroom_id']]));
        return;
    }

        // CSRF protection
    if (!isset($_POST['_token']) || !csrf('verify', $_POST['_token'])) {
        $_SESSION['error'] = 'Invalid security token';
        redirect(route('ietchats.room.show', ['id' => $_POST['to_chatroom_id']]));
        return;
    }

    // Sanitize & validate input
    $invitedUserId = intval($_POST['invited_user_id'] ?? 0);
    $chatroomId    = intval($_POST['to_chatroom_id'] ?? 0);
    $title         = trim($_POST['title'] ?? '');
    $description   = trim($_POST['description'] ?? '');

    // Validation rules
    if (!$invitedUserId || !$chatroomId || $title === '') {
        $_SESSION['error'] = 'تمام فیلدهای ضروری باید پر شوند.';
        redirect(route('ietchats.room.show', ['id' => $chatroomId]));
        return;
    }
// Check if user is already invited
if ($this->chatServices->isUserAlreadyInvitedToRoom($invitedUserId, $chatroomId)) {
    $_SESSION['error'] = 'این کاربر قبلاً به این اتاق دعوت شده است.';
    redirect(route('ietchats.room.show', ['id' => $chatroomId]));
    return;
}

    // Package data
    $data = [
        'invited_user_id' => $invitedUserId,
        'to_chatroom_id'  => $chatroomId,
        'title'           => $title,
        'description'     => $description
    ];

    // Call service
    $success = $this->chatServices->inviteUser($data);

    $_SESSION[$success ? 'success' : 'error'] = $success
        ? 'کاربر با موفقیت دعوت شد.'
        : 'دعوت کاربر با خطا مواجه شد.';

    redirect(route('ietchats.room.show', ['id' => $chatroomId]));
}


public function sendMessage()
{
    // ✅ Step 1: Ensure request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'درخواست نامعتبر است.';
        redirect(route('ietchats.room.show', ['id' => $_POST['to_chatroom_id'] ?? 0]));
        return;
    }

    // ✅ Step 2: Sanitize and extract data
    $senderId     = $_SESSION['user_id'] ?? 0; // Ensure logged-in user ID is available
    $chatroomId   = intval($_POST['to_chatroom_id'] ?? 0);
    $keyWords     = trim($_POST['key_words'] ?? '');
    $chatContext  = trim($_POST['chat_context'] ?? '');

    // ✅ Step 3: Validation
    if (!$senderId || !$chatroomId || $chatContext === '') {
        $_SESSION['error'] = 'متن پیام الزامی است.';
        redirect(route('ietchats.room.show', ['id' => $chatroomId]));
        return;
    }

    // ✅ Step 4: Package data
    $data = [
        'sender_id'      => $senderId,
        'to_chatroom_id' => $chatroomId,
        'key_words'      => $keyWords,
        'chat_context'   => $chatContext
    ];

    // ✅ Step 5: Call service to send message
    $success = $this->chatServices->sendMessage($data);

    // ✅ Step 6: Handle result
    $_SESSION[$success ? 'success' : 'error'] = $success
        ? 'پیام با موفقیت ارسال شد.'
        : 'ارسال پیام با خطا مواجه شد.';

    redirect(route('ietchats.room.show', ['id' => $chatroomId]));
}


}