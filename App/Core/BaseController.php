<?php

namespace App\Core;

use App\Core\Route;
use App\Helpers\Sanitizer;

class BaseController
{
    protected function render(string $view, array $data = [], string $layout = 'layout')
    {
        extract($data);
        $viewPath   = views_path($view . '.php');
        $layoutPath = views_path($layout . '.php');

        if (!file_exists($viewPath) || !file_exists($layoutPath)) {
            die("View or layout file not found.");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $layoutPath;
    }

    protected function redirect(string $path = '', array $queryParams = [])
    {
        redirect($path, $queryParams);
    }

    protected function baseUrl(string $path = ''): string
    {
        return base_url($path);
    }

    protected function route(string $name, array $params = []): string
    {
        return route($name, $params);
    }

    protected function isLoggedIn(): bool
    {
        return isLoggedIn();
    }
}
