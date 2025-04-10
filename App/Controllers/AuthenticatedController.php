<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;

class AuthenticatedController
{
    public function __construct()
    {
        AuthMiddleware::requireLogin(); // Don't assign void
    }

    public function dashboard()
    {
        return 'dashboard';
    }
}
