<?php 
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;
use App\FileServices\JsonStorageService;

class JsonAssetController extends BaseController
{
    public function save()
    {
        $data = $_POST;
        $type = sanitize($data['type']);
        $name = sanitize($data['name']);
        $config = json_decode($data['config'], true);

        $success = JsonStorageService::store($type, $name, $config);

        echo json_encode([
            'status' => $success ? 'success' : 'error',
            'message' => $success ? 'Saved' : 'Failed to save'
        ]);
    }

    public function fetch()
    {
        $type = sanitize($_GET['type']);
        $name = sanitize($_GET['name']);
        echo json_encode(JsonStorageService::fetch($type, $name));
    }
}
