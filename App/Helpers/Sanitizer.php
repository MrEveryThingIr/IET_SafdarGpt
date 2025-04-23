<?php
declare(strict_types=1);

namespace App\Helpers;

final class Sanitizer
{
    /** Recursively flatten an array to its first scalar, or return empty string. */
    public static function flatten(mixed $val): string
    {
        if (is_array($val)) {
            foreach ($val as $item) {
                $result = self::flatten($item);
                if ($result !== '') {
                    return $result;
                }
            }
            return '';
        }
        return (string)$val;
    }

    /** Escape HTML special chars safely. */
    public static function sanitize(string $str): string
    {
        return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
