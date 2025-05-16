<?php
// Safely load helpers
$helperFiles = [
    __DIR__.'/security/security_helpers.php',
    __DIR__.'/security/csrf_helpers.php',
    __DIR__.'/html_helpers/navbar_samples.php',
    __DIR__.'/html_helpers/navbar_helpers.php',
    __DIR__.'/html_helpers/sidebar_helpers.php',
    __DIR__.'/html_helpers/sidebar_samples.php',
    __DIR__.'/session_helpers.php'
];


foreach ($helperFiles as $file) {
    if (!file_exists($file)) {
        throw new RuntimeException("Helper file missing: {$file}");
    }
    require_once $file;
}

use App\Core\Route;

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
    $resolved = base_path('App/views/' . ltrim($path, '/'));
    error_log("🔍 views_path() => " . $resolved);
    return $resolved;
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

function config($key, $default = null) {
    return \App\Core\Env::get($key, $default);
}



function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}



function route($name, $params = []) {
    return Route::route($name, $params);
}

function flash(string $key): ?string {
    if (!isset($_SESSION[$key])) return null;

    $value = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $value;
}

function inputField(string $name, string $label, string $type = 'text', array $attrs = []): string
{
    $errors = $_SESSION['errors'][$name][0] ?? null;
    $value = $_POST[$name] ?? '';
    $html = '<div>';
    $html .= "<label for=\"{$name}\" class=\"block text-gray-700 font-medium\">{$label}</label>";
    $html .= "<input 
        type=\"{$type}\" 
        name=\"{$name}\" 
        id=\"{$name}\" 
        value=\"" . htmlspecialchars($value) . "\" 
        class=\"mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300\"";

    foreach ($attrs as $attr => $val) {
        $html .= " {$attr}=\"{$val}\"";
    }

    $html .= '>';

    if ($errors) {
        $html .= "<p class=\"text-red-500 text-sm mt-1\">{$errors}</p>";
    }

    $html .= '</div>';
    return $html;
}
use App\Models\User;
function user($id=null){
    $user=new User();
    if($id==null && isLoggedIn()){
        $user->id=$_SESSION['user_id'];
        return $user->fetchUserById();
    }elseif($id!=null){
        $user->id=$id;
        return $user->fetchUserById();
    }
}