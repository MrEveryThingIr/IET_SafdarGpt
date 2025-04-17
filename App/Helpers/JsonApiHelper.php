<?php
namespace App\Helpers;
class JsonApiHelper
{
    // Send JSON response
    public static function sendJsonResponse($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Get JSON body from incoming request (e.g., AJAX POST)
    public static function getJsonInput(): mixed
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true);
    }

    // Validate JSON string
    public static function isValidJson(string $json): bool
    {
        json_decode($json);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    // Make an API GET request
    public static function apiGet(string $url, array $headers = []): mixed
    {
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => self::formatHeaders($headers),
            ]
        ];
        return self::fetch($url, $opts);
    }

    // Make an API POST request with JSON body
    public static function apiPost(string $url, array $data, array $headers = []): mixed
    {
        $opts = [
            "http" => [
                "method" => "POST",
                "header" => self::formatHeaders($headers + ['Content-Type' => 'application/json']),
                "content" => json_encode($data)
            ]
        ];
        return self::fetch($url, $opts);
    }

    // Helper to format headers for HTTP context
    private static function formatHeaders(array $headers): string
    {
        $lines = [];
        foreach ($headers as $key => $value) {
            $lines[] = "$key: $value";
        }
        return implode("\r\n", $lines);
    }

    // Fetch API with stream context
    private static function fetch(string $url, array $opts): mixed
    {
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
}
