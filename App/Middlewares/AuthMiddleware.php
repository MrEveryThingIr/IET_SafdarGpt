<?php

namespace App\Middlewares;

class AuthMiddleware
{
    public static function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            $_SESSION['error'] = "You must be logged in to access that page.";
            redirect(route('home.login'));
        }
    }

    public static function guestOnly(): void
    {
        if (!empty($_SESSION['user_id'])) {
            header('Location: ' . base_url('dashboard')); // Or wherever users go
            exit;
        }
    }
}

