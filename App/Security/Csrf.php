<?php
declare(strict_types=1);

namespace App\Security;

class Csrf
{
    private const SESSION_KEY = 'csrf_token';

    /**
     * Generate a new CSRF token (auto-stores in session)
     */
    public function generate(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Verify a submitted token against the stored one
     */
    public function verify(?string $token): bool
    {
        if (empty($token)) {
            return false;
        }
        return isset($_SESSION[self::SESSION_KEY]) && 
               hash_equals($_SESSION[self::SESSION_KEY], $token);
    }

    /**
     * Generate HTML hidden input field with the token
     */
    public function field(): string
    {
        return sprintf(
            '<input type="hidden" name="_token" value="%s">',
            htmlspecialchars($this->generate(), ENT_QUOTES)
        );
    }

    /**
     * Regenerate the token (e.g., after login)
     */
    public function regenerate(): void
    {
        $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
    }
}