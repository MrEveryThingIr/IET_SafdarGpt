<?php
declare(strict_types=1);

namespace App\Services;

final class JsonApi
{
    /** Send a JSON response and exit. */
    public static function send(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /** Retrieve decoded JSON payload from the request body. */
    public static function input(): mixed
    {
        $raw = file_get_contents('php://input');
        return json_decode($raw, true);
    }

    /** Check if a string is valid JSON. */
    public static function isValid(string $json): bool
    {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /** Perform a GET request and return decoded JSON. */
    public static function get(string $url, array $headers = []): mixed
    {
        $opts = ['http' => ['method' => 'GET', 'header' => self::formatHeaders($headers)]];
        return self::fetch($url, $opts);
    }

    /** Perform a POST request with JSON body and return decoded JSON. */
    public static function post(string $url, mixed $data, array $headers = []): mixed
    {
        $headers['Content-Type'] = 'application/json';
        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => self::formatHeaders($headers),
                'content' => json_encode($data, JSON_UNESCAPED_UNICODE),
            ]
        ];
        return self::fetch($url, $opts);
    }

    private static function formatHeaders(array $headers): string
    {
        $lines = [];
        foreach ($headers as $k => $v) {
            $lines[] = sprintf("%s: %s", $k, $v);
        }
        return implode("\r\n", $lines);
    }

    private static function fetch(string $url, array $opts): mixed
    {
        $context  = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}
