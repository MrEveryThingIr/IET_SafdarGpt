<?php 
namespace App\Controllers\AuthenticatedControllers;
use App\Controllers\AuthenticatedController;
use App\HTMLServices\LayoutService;

class PlannerController extends AuthenticatedController
{
    private $layout;
    public function __construct(){
        $layout=new LayoutService();
        $this->layout=$layout->createAdminLayout();
       
    }
    public function renderCalendar()  {
        $html = $this->layout->render([
            'view'     => 'organisms/authenticated/planner',
            'viewData' => []
        ]);
        echo $html;
    }
}