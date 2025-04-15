<?php 
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;

class FormController extends BaseController
{
    public function create()   { $this->render('gui_form_create'); }
    public function index()    { $this->render('gui_form_index'); }
    public function style()    { $this->render('gui_form_style'); }
    public function script()   { $this->render('gui_form_script'); }
}
