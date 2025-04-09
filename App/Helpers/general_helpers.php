<?php

use App\Core\Route;
use App\FileServices\UploadService;
use App\Helpers\Sanitizer;

function base_url($path = '') {
    if (defined('BASE_URL')) {
        return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    }

    $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";

    $host = $_SERVER['HTTP_HOST'];
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

    return $protocol . $host . $base . '/' . ltrim($path, '/');
}

function base_path($path = '') {
    return realpath(__DIR__ . '/../../' . ltrim($path, '/')) ?: __DIR__ . '/../../' . ltrim($path, '/');
}

function views_path($path = '') {
    return base_path('App/views/' . ltrim($path, '/'));
}

function redirect($path = '', $queryParams = []) {
    $url = base_url($path);
    if (!empty($queryParams)) {
        $url .= '?' . http_build_query($queryParams);
    }
    header('Location: ' . $url);
    exit;
}

function render($view, $data = [], $layout = 'layout') {
    extract($data);
    $viewPath = views_path($view . '.php');
    $layoutPath = views_path($layout . '.php');

    if (!file_exists($viewPath) || !file_exists($layoutPath)) {
        die("View or layout file not found.");
    }

    ob_start();
    require $viewPath;
    $content = ob_get_clean();

    require $layoutPath;
}

function config($key) {
    $config = require base_path("config/config.php");
    foreach (explode(".", $key) as $k) {
        if (!isset($config[$k])) {
            throw new Exception("Config key '{$k}' not found.");
        }
        $config = $config[$k];
    }
    return $config;
}

function sanitize($value) {
    return Sanitizer::sanitizeHtmlEntities($value);
}

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

function uploads_path($filename = '') {
    return UploadService::uploadsPath($filename);
}

function uploads_url($filename = '') {
    return UploadService::uploadsUrl($filename);
}

function handleFileUpload($upload_category, $input_name, $allowed_types = [], $max_size = 5 * 1024 * 1024) {
    return UploadService::uploadFile($upload_category, $input_name, $allowed_types, $max_size);
}

function route($name, $params = []) {
    return Route::route($name, $params);
}
