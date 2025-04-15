<?php 
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;

class PreviewController extends BaseController
{
    public function index()
    {
        // Show the composed page (from selected layout + components)
        $this->render('gui_preview');
    }
}
