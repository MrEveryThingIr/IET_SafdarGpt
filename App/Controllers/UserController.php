<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\ModelServices\UserServices;

class UserController extends BaseController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('home.register');
        }

        $service = new UserServices();
        $result = $service->register($_POST);

        if ($result['success']) {
            $_SESSION['success'] = "Registration successful! Please log in.";
            $this->redirect(route('home.login'));
        }

        $_SESSION['errors'] = $result['errors'];
        $this->redirect(route('home.register'));
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(route('home.login'));
        }

        $service = new UserServices();
        $result = $service->authenticate($_POST);

        if ($result['success']) {
            $this->redirect(route('dashboard')); // or wherever your app lands
        }

        $_SESSION['errors'] = $result['errors'];
        $this->redirect(route('home.login'));
    }

    public function logout()
    {
        session_destroy();
        $this->redirect(route('home.login'));
    }
}
