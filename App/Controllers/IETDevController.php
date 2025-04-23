<?php

namespace App\Controllers;

use App\Core\BaseController;

class IETDevController extends BaseController
{
    public function showExampleForm() {
        echo $this->render('developer_graphical_interface/form_example',[]);
        } 
    public function showCreateFormForm() {
    echo $this->render('developer_graphical_interface/create_form',[]);
    }
    
}