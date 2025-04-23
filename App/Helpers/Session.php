<?php
declare(strict_types=1);

namespace App\Helpers;

final class Session
{
    /**
     * Flash data: if $value provided, set; otherwise get+clear.
     * @return mixed|null
     */
    public static function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $_SESSION[$key] = $value;
            return null;
        }
        $val = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $val;
    }

    /** Is the current user logged in? */
    public static function isLoggedIn(): bool
    {
        return !empty($_SESSION['user_id']);
    }
}
