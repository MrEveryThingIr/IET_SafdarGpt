<?php
namespace App\Controllers;
class TestController
{
    public $styles=[];
    public function __construct(){
        $this->styles=[base_url('assets/css/styles.css')];
    }
    public function testMethod(){
        
        render('test_view',['styles'=>$this->styles],'layout');
    }
}