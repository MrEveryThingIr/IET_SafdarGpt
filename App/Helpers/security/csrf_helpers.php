<?php
declare(strict_types=1);
use App\Security\Csrf;
/**
 * CSRF helper function
 */
function csrf(string $method = 'generate', ?string $token = null)
{
    static $csrf = null;
    
    if ($csrf === null) {
        if (!class_exists('App\Security\Csrf')) {
            throw new RuntimeException('CSRF class not found. Ensure it is properly autoloaded.');
        }
        $csrf = new Csrf();
    }

    switch ($method) {
        case 'verify':
            if ($token === null) {
                throw new InvalidArgumentException('Token required for verification');
            }
            return $csrf->verify($token);

        case 'field':
            return $csrf->field();

        case 'regenerate':
            $csrf->regenerate();
            return true;

        case 'generate':
            return $csrf->generate();

        default:
            throw new InvalidArgumentException("Invalid CSRF method: {$method}");
    }
}