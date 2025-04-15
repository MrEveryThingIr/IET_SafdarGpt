<?php 
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;

class NavbarController extends BaseController
{
    public function create()   { $this->render('gui_navbar_create'); }
    public function index()    { $this->render('gui_navbar_index'); }
    public function style()    { $this->render('gui_navbar_style'); }
    public function script()   { $this->render('gui_navbar_script'); }
}
