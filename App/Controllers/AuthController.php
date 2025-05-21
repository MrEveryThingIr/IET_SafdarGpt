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
        $navbar=home_navbar();
        $this->layout = new Layout($navbar, $sidebar = null, [
            'title' => 'خانه',
            'template' => 'layouts/main_layout',
            
        ]);
    } 
    
    public function allAnnounces(){
        redirect(route('ietannounce.all'));
    }
    public function filteredAnnounces($filter)
    {
        redirect(route('ietannounce.filtered'));
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
        
        $dashboard_navbar=dashboardnavbar();
        $dashboard_sidebar=dashboardsidebar();
       
        
        $this->layout = new Layout($dashboard_navbar, $dashboard_sidebar, [
            'title' => 'خانه',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);
        $this->render('auth/dashboard',[],[]);
    }
    
}
