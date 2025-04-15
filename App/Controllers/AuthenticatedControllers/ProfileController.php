<?php

namespace App\Controllers\AuthenticatedControllers;
use App\Controllers\AuthenticatedController;
use App\HTMLServices\LayoutService;
class   ProfileController extends AuthenticatedController
{
    public function profile() {
        $layout=new LayoutService();
        $layout=$layout->createDeveloperLayout();
        $html = $layout->render([
            'view'     => 'organisms/authenticated/profile',
            'viewData' => ['user'=>(array)$this->currentUser]
        ]);

        echo $html;
    }
    public function edit(){
        echo 'edit';
    }
}