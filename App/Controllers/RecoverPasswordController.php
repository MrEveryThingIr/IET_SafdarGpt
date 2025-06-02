<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;
use App\Models\RecoverPassword;
use App\Services\EmailService;
use App\HTMLRenderer\Layout;

class RecoverPasswordController extends BaseController
{
    public function __construct(){
        $navbar=home_navbar();
        $this->layout = new Layout($navbar, $sidebar = null, [
            'title' => 'خانه',
            'template' => 'layouts/main_layout',
            'stylesPaths'=>['assets/css/moving_time.css'],
            'scriptsPaths'=>['assets/js/temporary/movingtime.js']
            
        ]);
    } 
    public function showRequestForm(): void
    {
        echo $this->render('auth/recoverpassword/request_password_reset');
    }

    public function requestRecoverPassword(): void
    {
        
        try {
            if (!csrf('verify', $_POST['_token'] ?? null)) {
                throw new \RuntimeException('CSRF validation failed');
            }

            $email = clean('to', $_POST['to'] ?? '');

            if (empty($email)) {
                throw new \InvalidArgumentException('Email is required.');
            }

            $userModel = new User();
            $user = $userModel->fetchUserByEmail($email);

            if (!$user) {
                throw new \RuntimeException('No user found with this email.');
            }

            $token = RecoverPassword::generateToken();
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $RecoverPasswordModel = new RecoverPassword();
            $RecoverPasswordModel->createResetToken($user['id'], $hashedToken, $expiry);

            $resetLink = route('recoverpassword.resetform', ['token' => $token]);
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
            redirect(route('recoverpass.requestform'));
        }
    }

    public function showResetForm(string $token): void
    {
        $RecoverPasswordModel = new RecoverPassword();
        $resetRecord = $RecoverPasswordModel->getByToken($token);

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

            $RecoverPasswordModel = new RecoverPassword();
            $resetRecord = $RecoverPasswordModel->getByToken($token);

            if (!$resetRecord || strtotime($resetRecord['expires_at']) < time()) {
                throw new \RuntimeException('Invalid or expired token.');
            }

            $userModel = new User();
            $userModel->id=$resetRecord['user_id'];
            $user = $userModel->fetchUserById();
            if (!$user) {
                throw new \RuntimeException('User not found.');
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $userModel->updatePassword($user['id'], $hashedPassword);

            $RecoverPasswordModel->deleteByToken($token);

            $_SESSION['success'] = 'Your password has been reset successfully.';
            redirect(route('auth.login'));
        } catch (\Exception $e) {
            error_log('Password reset failed: ' . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            redirect(route('recoverpassword.resetform', ['token' => $_POST['token'] ?? '']));
        }
    }

 
}
