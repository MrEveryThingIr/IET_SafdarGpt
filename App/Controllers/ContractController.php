<?php 
namespace App\Controllers;

use App\Core\BaseController;

class ContractController extends BaseController
{
    public function createContract(){
        $this->render('contracts/create',[],[]);
    }
}