<?php

session_start();

use App\Core\Env;

Env::load(); // load from .env

if (!defined('BASE_URL')) {
    define('BASE_URL', Env::get('APP_BASE_URL', 'http://localhost/'));
}

if (!defined('ADMIN_PHONE_NUMBERS')) {
    define('ADMIN_PHONE_NUMBERS', explode(',', Env::get('ADMIN_PHONES', '')));
}
