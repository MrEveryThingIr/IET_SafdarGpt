<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\User;
use App\ModelServices\UserServices;

abstract class AuthenticatedController
{
    protected ?User $currentUser = null;

    public function __construct()
    {
        AuthMiddleware::requireLogin(); // Block access for guests
        $this->currentUser = $this->fetchCurrentUser();
    }

    /**
     * Get the current authenticated user from the session.
     */
    protected function fetchCurrentUser(): ?User
    {
        if (!isset($_SESSION['user_id'])) return null;
    
        $userService = new UserServices();
        return $userService->fetchUserById($_SESSION['user_id']);
    }
    

    /**
     * Get user object in child controllers.
     */
    protected function user(): ?User
    {
        return $this->currentUser;
    }

    /**
     * Optional: authorization guard for specific roles
     */
    protected function authorize(array $allowedRoles): void
    {
        if (!in_array($this->user()->role ?? '', $allowedRoles)) {
            header('Location: ' . base_url('unauthorized'));
            exit;
        }
    }
}
