<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\Models\User;
use App\Helpers\UploadFile;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;

// use function App\Helpers\sanitize;
// use function App\Helpers\sanitize_email;
// use function App\Helpers\redirect;
// use function App\Helpers\isLoggedIn;
// use function App\Helpers\route;

class AuthController extends BaseController
{

    public function home(){
        redirect(route('ietdashboard'));
    }
    public function showRegisterForm(): void
    {
        echo $this->render('auth/register');
    }

    public function register(): void
    {
        $user = new User();
    
        $user->firstname = $_POST['firstname'] ?? '';
        $user->lastname = $_POST['lastname'] ?? '';
        $user->username = $_POST['username'] ?? '';
        $user->phone = $_POST['phone'] ?? '';
        $user->email = $_POST['email'] ?? '';
        $user->role = $_POST['role'] ?? '';
        $user->main_job = $_POST['main_job'] ?? '';
        $user->birthdate = $_POST['birthdate'] ?? '';
        $user->password = $_POST['password'] ?? '';
        $user->gender = $_POST['gender'] ?? '';
    
        $uploadResult = UploadFile::upload('image', 'img');
        $user->img = $uploadResult['success'] ? $uploadResult['url'] : '';
    
        if ($user->store()) {
            redirect(route('auth.login'));
        } else {
            echo "Error storing user.";
        }
    }
    
    public function showLoginForm(): void
    {
        echo $this->render('auth/login');
    }

    public function login(): void
    {
        $user = new User();
        $user->email = $_POST['email'] ?? '';
        $user->password = $_POST['password'] ?? '';

        if ($user->login()) {
            $_SESSION['user_id'] = $user->id;
            redirect(route('ietdashboard'));
        } else {
            echo "Login failed.";
        }
    }

    public function logout(): void
    {
        session_destroy();
        redirect(route('auth.login'));
    }

    public function dashboard(): void
    {
        if (!isLoggedIn()) {
            echo 'isnotloggedin';
            // redirect(route('auth.login'));
            // $this->logout();
        }
    
        $userModel = new User();
        $userModel->id = $_SESSION['user_id'];
        $user = $userModel->fetchUserById();
    
        $this->layout = new Layout(
            new Navbar([
                'brand' => 'IET_Post',
                'items' => [
                    ['label' => 'Dashboard', 'href' => route('ietdashboard')],
                    ['label' => 'Profile', 'href' => '#'],
                    ['label' => 'Logout', 'href' => route('auth.logout')]
                ],
                'stylesPaths' => [
                    '/assets/css/navbar.css'
                ],
                'scriptsPaths' => [
                    '/assets/js/navbar.js'
                ]
            ]),
            new Sidebar([
                'items' => [
                    ['label' => 'Create Post', 'href' => route('ietpost.create')],
                    ['label' => 'My Posts', 'href' => route('ietpost.my')],
                    ['label' => 'Archived', 'href' => route('ietpost.archived')],
                    ['label' => 'All Posts', 'href' => route('ietpost.all')],
                    ['label' => 'Meetings', 'href' => route('ietmeeting.create')],
                ],
                'stylesPaths' => [
                    '/assets/css/sidebar.css'
                ],
                'scriptsPaths' => [
                    '/assets/js/sidebar.js'
                ]
            ]),
            [
                'title' => 'User Dashboard',
                'stylesPaths' => [
                    '/assets/css/dashboard.css'
                ],
                'scriptsPaths' => [
                    '/assets/js/dashboard.js'
                ],
                'template' => 'layouts/main_layout'
            ]
        );
    
        echo $this->layout->render([
            'view' => 'auth/dashboard',
            'viewData' => ['user' => $user]
        ]);
    }
    
}
