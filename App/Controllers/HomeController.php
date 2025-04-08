<?php
namespace App\Controllers;

use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\HTMLRenderer\Layout;

class HomeController
{
    public function index()
    {
        // If user hits /home, redirect to login route
        redirect(route('home.login'));
    }

    public function registration()
    {
        // 1) Create a Navbar with config
        $navbar = new Navbar([
            'brand'        => 'My Site',
            'items'        => [
                'Home'  => route('home'),
                'Login' => route('home.login'),
            ],
            'stylesPaths'  => ['assets/css/navbar_custom.css'],
            'scriptsPaths' => ['assets/js/navbar_behavior.js']
        ]);

        // 2) Create a Sidebar with config
        $sidebar = new Sidebar([
            'items'        => ['Dashboard', 'Settings', 'Help'],
            'stylesPaths'  => ['assets/css/sidebar_custom.css'],
            'scriptsPaths' => []
        ]);

        // 3) Create a Layout
        //    We can pass its own styles/scripts, plus a title, etc.
        $layout = new Layout($navbar, $sidebar, [
            'title'       => 'Registration Page',
            'stylesPaths' => ['assets/css/layout_overrides.css'],
            'scriptsPaths'=> ['assets/js/layout_interactions.js'],
            // 'layoutView' => 'layout', // default if we want "views/layout.php"
        ]);

        // 4) Render the "home/register" view as main content
        $html = $layout->render([
            'view'     => 'forms/register', // => "views/home/register.php"
            'viewData' => [
                // any data needed in the register form
                // e.g. 'roles' => ['admin', 'user', 'editor'],
            ]
        ]);

        echo $html;
    }

    public function login()
    {
        // You could similarly create a different or simpler navbar
        $navbar = new Navbar([
            'brand'        => 'My Site',
            'items'        => [
                'Home' => route('home')
            ],
        ]);

        // Maybe no sidebar for login
        $sidebar = null;

        // Layout with minimal styles
        $layout = new Layout($navbar, $sidebar, [
            'title'       => 'Login Page'
        ]);

        $html = $layout->render([
            'view' => 'forms/login',
            'viewData' => []
        ]);

        echo $html;
    }
}
