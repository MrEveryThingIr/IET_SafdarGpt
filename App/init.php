<?php

session_start();

use App\Core\Env;

Env::load(); // load from .env

if (!defined('BASE_URL')) {
    define('BASE_URL', Env::get('APP_BASE_URL', 'http://localhost/'));
}

 // Set timezone for comparison
date_default_timezone_set('Asia/Tehran');
