<?php 
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\HTMLServices\LayoutService; // ✅ FIXED
use App\HTMLServices\FormService;

class FormController extends BaseController
{
    public function create()
    {
        $layoutService = new LayoutService();
        $layout = $layoutService->createDeveloperLayout();

        // No need to call FormService manually unless previewing.
        echo $layout->render([
            'view' => 'developer_interface/form_create',
            'viewData' => []
        ]);
    }

    public function index()    { $this->render('gui_form_index'); }
    public function style()    { $this->render('gui_form_style'); }
    public function script()   { $this->render('gui_form_script'); }
}
