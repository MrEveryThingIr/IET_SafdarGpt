<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\Models\User;
use App\Helpers\UploadFile;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\Models\IETAnnounce;

class AuthController extends BaseController
{
    public function __construct(){
        // Prepare items array based on authentication status
$items = [
    [
        'label' => 'معرفی',
        'href' => route('iethome'),
        'class' => 'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2 hover:bg-green-800 transition-colors'
    ],
    [
        'label' => 'اعلام‌ها',
        'href' => route('ietannounce.all'),
        'class' => 'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2 hover:bg-green-800 transition-colors'
    ],
 
];

// Add conditional items based on login status
if (!isLoggedIn()) {
    array_unshift($items, [
        'label' => 'عضویت',
        'href' => route('auth.register'),
        'class' => 'text-gray-700 hover:text-blue-600 px-4 py-2 text-lg font-medium'
    ]);
    array_unshift($items, [
        'label' => 'وارد شوید',
        'href' => route('auth.login'),
        'class' => 'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2 hover:bg-green-800 transition-colors'
    ]);
} else {
   
    // Get current user data (example - adjust according to your user system)
    $user =currentUser();
    
// User profile item - corrected version
array_unshift($items, 
    [
    'label' => $user['firstname'] . ' ' . $user['lastname'],
    'href' => route('user.profile',['feature'=>'identification']),
    'class' => 'flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium',
    'icon' => '<img src="' . $user['img'] . '" class="w-8 h-8 rounded-full object-cover">',
],
    
[
    'label' => 'خروج',
    'form' => true, // Flag to indicate this is a form
    'action' => route('auth.logout'),
    'class' => 'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2',
    'method' => 'POST'
],
);
}

// Initialize navbar
$navbar = new Navbar([
    'brand' => [
        'label' => 'IET System',
        'href' => route('iethome'),
        'class' => 'text-2xl font-bold text-gray-800 hover:text-blue-600'
    ],
    'items' => $items
]);
        $this->layout = new Layout($navbar, $sidebar=null, [
            'title' => 'خانه',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);
    }

    public function all()
    {
        $announceModel = new IETAnnounce();
        $all = $announceModel->specified('', [''], '');
        
        $this->render('iet_announce/all', [
            'announces' => $all
        ], ['modalHelper']); // Just specify helper file name
    }

    public function home(){

        $this->render('home',[],[]);
    }
    public function showRegisterForm(): void
    {
        echo $this->render('auth/register',[]);
    }

    public function register(): void
    {
        try {
            // CSRF verification
            if (!csrf('verify', $_POST['_token'] ?? null)) {
                throw new \RuntimeException('CSRF validation failed');
            }
    
            // Validate required fields
            $requiredFields = ['firstname', 'lastname', 'username', 'email', 'password', 'role'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    throw new \InvalidArgumentException("Missing required field: {$field}");
                }
            }
    
            // Sanitize all inputs
            $user = new User();
            $user->firstname = clean('text', $_POST['firstname'] ?? '');
            $user->lastname = clean('text', $_POST['lastname'] ?? '');
            $user->username = clean('username', $_POST['username'] ?? '');
            $user->phone = clean('number', $_POST['phone'] ?? '');
            $user->email = clean('email', $_POST['email'] ?? '');
            $user->role = in_array($_POST['role'] ?? '', ['user', 'admin']) ? $_POST['role'] : 'user';
            $user->main_job = clean('text', $_POST['main_job'] ?? '');
            $user->birthdate = !empty($_POST['birthdate']) ? date('Y-m-d', strtotime($_POST['birthdate'])) : null;
            $user->gender = in_array($_POST['gender'] ?? '', ['male', 'female', 'other']) ? $_POST['gender'] : null;
            
            // Password handling
            $password = $_POST['password'] ?? '';
            if (strlen($password) < 8) {
                throw new \InvalidArgumentException('Password must be at least 8 characters');
            }
            $user->password = password_hash($password, PASSWORD_DEFAULT);
    
            // File upload with validation
            $uploadResult = UploadFile::upload('user/profile_images', 'img', [
                'max_size' => 2 * 1024 * 1024, // 2MB
                'allowed_types' => ['image/jpeg', 'image/png', 'image/gif']
            ]);
            
            if ($uploadResult['success']) {
                $user->img = $uploadResult['url'];
                $_SESSION['upload_result'] = "File uploaded successfully";
            } else {
                $_SESSION['upload_result'] = "Error: " . $uploadResult['error'];
                // Continue without image if upload fails
            }
    
            if ($user->store()) {
                redirect(route('auth.login'));
            } else {
                throw new \RuntimeException('Failed to store user');
            }
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());
            
            // Store error message for display
            $_SESSION['register_error'] = $e->getMessage();
            redirect(route('auth.register'));
        }
    }
    public function showLoginForm(): void
    {
        echo $this->render('auth/login');
    }

    public function login(): void
    {
        try {
            // CSRF verification
            if (!csrf('verify', $_POST['_token'] ?? null)) {
                throw new \RuntimeException('Invalid request');
            }
    
            // Sanitize inputs
            $identifier = clean('text', $_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
    
            if (empty($identifier) || empty($password)) {
                throw new \InvalidArgumentException('Email/username and password are required');
            }
    
            $user = new User();
            $user->email=$identifier;
            $user->password=$password;
            // Attempt login (method should verify password hash)
            if ($user->login()) {
                // Regenerate session ID to prevent fixation
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
                
                redirect(route('dashboard'));
            } else {
                // Generic error message to prevent user enumeration
                throw new \RuntimeException('Invalid credentials');
            }
        } catch (\Exception $e) {
            // Log the error (without sensitive info)
            error_log('Login attempt failed: ' . $e->getMessage());
            
            // Show generic error and redirect back
            $_SESSION['login_error'] = 'Login failed. Please try again.';
            redirect(route('auth.login'));
        }
    }
    public function logout(): void
    {
        // Verify CSRF token
        if (!csrf('verify', $_POST['_token'] ?? null)) {
            throw new \RuntimeException('Invalid logout request');
        }
    
        // Clear session
        session_destroy();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        redirect(route('auth.login'));
    }
    public function dashboard(){
        if(!isLoggedIn()){
            redirect(route('iethome'));
        }
        $navbar=new Navbar([
            'brand'=>'IET System',
            'items'=>[
                ['label'=>'پروفایل','href'=>route('user.profile',['feature'=>'identification']),'class'=>'bg-black m-1 text-white text-lg font-semibold rounded-md p-2'],
                [
                    'label' => 'خروج',
                    'form' => true, // Flag to indicate this is a form
                    'action' => route('auth.logout'),
                    'class' => 'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2',
                    'method' => 'POST'
                ],
                ['label'=>'خانه','href'=>route('iethome'),'class'=>'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2'],
                // ['label'=>'اعلام ها','href'=>route('ietannounce.all'),'class'=>'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2'],
            
            ]
        ]);
        $sidebar=new Sidebar([
            'items'=>[
                ['label'=>'افزودن اعلام جدید','href'=>route('ietannounce.create')]
            ],
        ]);
        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'خانه',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);
        $this->render('auth/dashboard',[],[]);
    }
    
}
