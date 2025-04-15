<?php 
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;

class LayoutBuilderController extends BaseController
{
    public function create()
    {
        $this->render('gui_layout_create');
    }

    public function store()
    {
        // Handle layout config saving (to JSON)
        // Validate input and store to GUI_createdObjectsByUser/layouts/{name}.json
    }
}
