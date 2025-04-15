<?php 
namespace App\Controllers\DeveloperInterfaceControllers;

use App\Core\BaseController;

class SidebarController extends BaseController
{
    public function create()   { $this->render('gui_sidebar_create'); }
    public function index()    { $this->render('gui_sidebar_index'); }
    public function style()    { $this->render('gui_sidebar_style'); }
    public function script()   { $this->render('gui_sidebar_script'); }
}
