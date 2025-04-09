<?php

namespace App\Helpers;

class Sanitizer
{
    public static function sanitizeString(string $input): string
    {
        return trim(filter_var($input, FILTER_SANITIZE_STRING));
    }

    public static function sanitizeEmail(string $input): string
    {
        return filter_var(trim($input), FILTER_SANITIZE_EMAIL);
    }

    public static function sanitizeUrl(string $input): string
    {
        return filter_var(trim($input), FILTER_SANITIZE_URL);
    }

    public static function stripHtmlTags(string $input): string
    {
        return strip_tags(trim($input));
    }

    public static function sanitizeHtmlEntities(string $input): string
    {
        return htmlentities(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeFilename(string $filename): string
    {
        return preg_replace('/[^A-Za-z0-9_\-\.]/', '', $filename);
    }


}
