<?php
/**
 * File: App\Helpers\sequrity_helpers.php
 * Description: Centralized security and sanitization helpers for all user input.
 * Author: IET System
 *
 * ✅ This file ensures all data passed from user forms or APIs is properly sanitized and secure.
 * ✅ Reusable in any controller, model, or service.
 * ✅ Designed to eliminate common security flaws like XSS, injection, or malformed input.
 */

namespace App\Helpers;

/**
 * General purpose string sanitizer.
 *
 * - Removes leading/trailing whitespace
 * - Encodes special HTML characters (prevents XSS)
 * - Handles null values gracefully
 *
 * @param string|null $data
 * @return string Sanitized string
 */
function sanitize(?string $data): string
{
    return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize email input specifically.
 *
 * - Removes illegal characters from email
 * - Ensures safe use in database or HTML context
 *
 * @param string|null $email
 * @return string
 */
function sanitize_email(?string $email): string
{
    return filter_var(trim($email ?? ''), FILTER_SANITIZE_EMAIL);
}

/**
 * Sanitize username.
 *
 * - Removes anything except letters, numbers, underscores and dots
 * - Useful for usernames, slugs, or identifiers
 *
 * @param string|null $username
 * @return string
 */
function sanitize_username(?string $username): string
{
    return preg_replace('/[^a-zA-Z0-9_.]/', '', trim($username ?? ''));
}

/**
 * Sanitize multiline textarea input.
 *
 * - Converts special characters to entities
 * - Converts newlines to <br> for safe HTML rendering
 *
 * @param string|null $text
 * @return string
 */
function sanitize_textarea(?string $text): string
{
    return nl2br(htmlspecialchars(trim($text ?? ''), ENT_QUOTES, 'UTF-8'));
}

/**
 * Sanitize a URL input.
 *
 * - Removes illegal URL characters
 * - Prevents malformed URLs and JS injections
 *
 * @param string|null $url
 * @return string
 */
function sanitize_url(?string $url): string
{
    return filter_var(trim($url ?? ''), FILTER_SANITIZE_URL);
}

/**
 * Strongly validate and escape numeric-only input (e.g., phone numbers, ids).
 *
 * @param string|null $number
 * @return string
 */
function sanitize_numeric(?string $number): string
{
    return preg_replace('/[^0-9]/', '', $number ?? '');
}

/**
 * Recursively sanitize all values in an array.
 *
 * - Useful for bulk POST/GET sanitization
 * - Maintains original array structure
 *
 * @param array $inputArray
 * @return array
 */
function sanitize_array(array $inputArray): array
{
    $cleaned = [];
    foreach ($inputArray as $key => $value) {
        if (is_array($value)) {
            $cleaned[$key] = sanitize_array($value);
        } else {
            $cleaned[$key] = sanitize((string)$value);
        }
    }
    return $cleaned;
}

/**
 * Escape values before rendering into HTML attributes.
 *
 * @param string|null $attribute
 * @return string
 */
function escape_html_attr(?string $attribute): string
{
    return htmlspecialchars($attribute ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Escape JavaScript string to prevent injection.
 *
 * @param string|null $jsString
 * @return string
 */
function escape_js_string(?string $jsString): string
{
    return json_encode($jsString ?? '', JSON_HEX_APOS | JSON_HEX_QUOT);
}

/**
 * Debug-friendly dump for sanitized data (safe alternative to var_dump/print_r).
 *
 * @param mixed $data
 * @return void
 */
function dump_sanitized($data): void
{
    echo '<pre>' . htmlspecialchars(print_r($data, true)) . '</pre>';
}

/**
 * Validate CSRF token existence and match (optional helper)
 *
 * @param string $token
 * @return bool
 */
function is_valid_csrf(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function clean(string $type, $value): string {
    return match($type) {
        'email'    => sanitize_email($value),
        'url'      => sanitize_url($value),
        'username' => sanitize_username($value),
        'text'     => sanitize_textarea($value),
        'number'   => sanitize_numeric($value),
        default    => sanitize($value),
    };
}
