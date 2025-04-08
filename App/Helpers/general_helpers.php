<?php 

use App\Core\Route;

function base_url($path = '') {
    if (defined('BASE_URL')) {
        return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    }

    $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 
        ? "https://" 
        : "http://";

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

    if (!file_exists($viewPath)) {
        die("View file not found: " . $viewPath);
    }

    if (!file_exists($layoutPath)) {
        die("Layout file not found: " . $layoutPath);
    }

    ob_start();
    require $viewPath;
    $content = ob_get_clean();

    require $layoutPath;
}

function config($key) {
    $config = require base_path("config/config.php");
    $keys = explode(".", $key);
    $value = $config;
    foreach ($keys as $k) {
        if (!isset($value[$k])) {
            throw new Exception("The key '{$k}' was not found in the configuration.");
        }
        $value = $value[$k];
    }
    return $value;
}

function sanitize($value) {
    return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
}

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

/**
 * Get the full file system path for uploads.
 *
 * @param string $filename Optional filename to append.
 * @return string Full uploads path.
 */
function uploads_path($filename = '') {
    $path = base_path('public/assets/uploads') . DIRECTORY_SEPARATOR . ltrim($filename, DIRECTORY_SEPARATOR);
    return str_replace(['\\', '//'], '/', $path); // Normalize path
}

/**
 * Get the full URL for uploaded files.
 *
 * @param string $filename Optional filename to append.
 * @return string Full uploads URL.
 */
function uploads_url($filename = '') {
    return base_url('assets/uploads/' . ltrim($filename, '/'));
}

/**
 * Handle file uploads securely and return the uploaded file name or false on failure.
 *
 * @param string $upload_category Directory category for the file.
 * @param string $input_name Name of the file input field.
 * @param array $allowed_types Allowed MIME types for security.
 * @param int $max_size Maximum allowed file size in bytes.
 * @return string|false Uploaded file name on success, false on failure.
 */
function handleFileUpload($upload_category, $input_name, $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'], $max_size = 5 * 1024 * 1024) {
    if (!isset($_FILES[$input_name]) || $_FILES[$input_name]['error'] !== UPLOAD_ERR_OK) {
        error_log("File upload error: " . $_FILES[$input_name]['error']);
        return false;
    }

    // Get target directory
    $targetDir = uploads_path($upload_category);
    error_log("Target Directory: " . $targetDir);

    // Ensure directory exists
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0755, true)) {
            error_log("Failed to create directory: " . $targetDir);
            return false;
        }
    }

    // Get file details
    $fileTmpPath  = $_FILES[$input_name]['tmp_name'];
    $originalName = basename($_FILES[$input_name]['name']);
    $fileSize     = $_FILES[$input_name]['size'];
    $fileMimeType = mime_content_type($fileTmpPath);

    // Validate MIME type
    if (!in_array($fileMimeType, $allowed_types)) {
        error_log("Invalid file type: $fileMimeType");
        return false;
    }

    // Validate file size
    if ($fileSize > $max_size) {
        error_log("File is too large: $fileSize bytes");
        return false;
    }

    // Generate safe filename
    $fileExt = pathinfo($originalName, PATHINFO_EXTENSION);
    $safeFileName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $fileExt;
    $targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $safeFileName;

    error_log("Moving file to: " . $targetFilePath);

    // Move file to final destination
    if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
        return $safeFileName;
    } else {
        error_log("Failed to move uploaded file.");
        return false;
    }
}

function route($name, $params = []) {
    return Route::route($name, $params);
}











