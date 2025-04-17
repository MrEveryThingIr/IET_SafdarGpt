<?php

namespace App\Controllers;

use App\Helpers\JsonApiHelper;
use App\Models\JsonModel\FormJsonModel;

class JsonFlowController
{
    private string $view;

    public function __construct(string $view = '')
    {
        $this->view = $view;
    }

    // This method will be called via route
    public function apiViewConfig(string $view_name): void
    {
        $safeView = basename($view_name); // security
        $model = new FormJsonModel();
        $config = $model->getConfigArray($safeView);

        JsonApiHelper::sendJsonResponse($config);
    }

    // Optional direct use in backend (if still needed)
    public function sendJsonResponse(): void
    {
        $model = new FormJsonModel();
        $config = $model->getConfigArray($this->view);
        JsonApiHelper::sendJsonResponse($config);
    }
}
