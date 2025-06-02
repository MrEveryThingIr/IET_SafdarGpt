<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;
use App\Models\PasswordReset;
use App\Services\EmailService;

class RecoverPasswordController extends BaseController
{
    public function showRequestForm(): void
    {
        echo $this->render('auth/request_password_reset');
    }

    public function requestPasswordReset(): void
    {
        try {
            if (!csrf('verify', $_POST['_token'] ?? null)) {
                throw new \RuntimeException('CSRF validation failed');
            }

            $email = clean('email', $_POST['email'] ?? '');

            if (empty($email)) {
                throw new \InvalidArgumentException('Email is required.');
            }

            $userModel = new User();
            $user = $userModel->fetchByEmail($email);

            if (!$user) {
                throw new \RuntimeException('No user found with this email.');
            }

            $token = PasswordReset::generateToken();
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $passwordResetModel = new PasswordReset();
            $passwordResetModel->createResetToken($user['id'], $hashedToken, $expiry);

            $resetLink = route('password.reset_form', ['token' => $token]);
            $emailBody = "Dear {$user['firstname']},<br><br>" .
                         "Click the link below to reset your password. This link will expire in 1 hour.<br>" .
                         "<a href='{$resetLink}'>Reset Password</a><br><br>" .
                         "If you did not request this, please ignore this email.";

            $emailService = new EmailService();
            $emailService->send($email, 'Password Recovery', $emailBody);

            $_SESSION['success'] = 'Password reset instructions sent to your email.';
            redirect(route('auth.login'));
        } catch (\Exception $e) {
            error_log("Password reset request error: " . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            redirect(route('password.request_form'));
        }
    }

    public function showResetForm(string $token): void
    {
        $passwordResetModel = new PasswordReset();
        $resetRecord = $passwordResetModel->getByToken($token);

        if (!$resetRecord || strtotime($resetRecord['expires_at']) < time()) {
            $_SESSION['error'] = 'Invalid or expired token.';
            redirect(route('auth.login'));
        }

        echo $this->render('auth/reset_password', ['token' => $token]);
    }

    public function resetPassword(): void
    {
        try {
            if (!csrf('verify', $_POST['_token'] ?? null)) {
                throw new \RuntimeException('Invalid CSRF token.');
            }

            $token = $_POST['token'] ?? '';
            $newPassword = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($token) || empty($newPassword) || empty($confirmPassword)) {
                throw new \InvalidArgumentException('All fields are required.');
            }

            if ($newPassword !== $confirmPassword) {
                throw new \InvalidArgumentException('Passwords do not match.');
            }

            if (strlen($newPassword) < 8) {
                throw new \InvalidArgumentException('Password must be at least 8 characters.');
            }

            $passwordResetModel = new PasswordReset();
            $resetRecord = $passwordResetModel->getByToken($token);

            if (!$resetRecord || strtotime($resetRecord['expires_at']) < time()) {
                throw new \RuntimeException('Invalid or expired token.');
            }

            $userModel = new User();
            $user = $userModel->fetchById($resetRecord['user_id']);
            if (!$user) {
                throw new \RuntimeException('User not found.');
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $userModel->updatePassword($user['id'], $hashedPassword);

            $passwordResetModel->deleteByToken($token);

            $_SESSION['success'] = 'Your password has been reset successfully.';
            redirect(route('auth.login'));
        } catch (\Exception $e) {
            error_log('Password reset failed: ' . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            redirect(route('password.reset_form', ['token' => $_POST['token'] ?? '']));
        }
    }

    public function showChangePasswordForm(): void
    {
        if (!isLoggedIn()) {
            redirect(route('auth.login'));
        }

        echo $this->render('auth/change_password');
    }

    public function changePassword(): void
    {
        try {
            if (!csrf('verify', $_POST['_token'] ?? null)) {
                throw new \RuntimeException('Invalid CSRF token.');
            }

            $userId = $_SESSION['user_id'] ?? null;
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (!$userId || empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                throw new \InvalidArgumentException('All fields are required.');
            }

            if ($newPassword !== $confirmPassword) {
                throw new \InvalidArgumentException('Passwords do not match.');
            }

            if (strlen($newPassword) < 8) {
                throw new \InvalidArgumentException('New password must be at least 8 characters.');
            }

            $userModel = new User();
            $user = $userModel->fetchById($userId);

            if (!$user || !password_verify($currentPassword, $user['password'])) {
                throw new \RuntimeException('Current password is incorrect.');
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $userModel->updatePassword($userId, $hashedPassword);

            $_SESSION['success'] = 'Your password has been updated.';
            redirect(route('dashboard'));
        } catch (\Exception $e) {
            error_log("Change password error: " . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            redirect(route('auth.change_password'));
        }
    }
}
