<?php

namespace App\Core;

class Env
{
    protected static $loaded = false;

    public static function load($path = __DIR__ . '/../../.env')
    {
        if (self::$loaded) return;
        if (!file_exists($path)) return;

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;

            list($key, $value) = array_map('trim', explode('=', $line, 2));

            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = self::parseValue($value);
            }
        }

        self::$loaded = true;
    }

    public static function get($key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }

    protected static function parseValue($value)
    {
        // Remove quotes if present
        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            return substr($value, 1, -1);
        }

        if ($value === 'true') return true;
        if ($value === 'false') return false;

        return $value;
    }
}
