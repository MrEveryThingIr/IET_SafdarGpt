<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoloader
require_once __DIR__ . '/../App/init.php';        // Your constants/config setup

use App\Core\Route;

require_once __DIR__ . '/../routes/web.php';      // Your route definitions

Route::dispatch();                                // Run the router
