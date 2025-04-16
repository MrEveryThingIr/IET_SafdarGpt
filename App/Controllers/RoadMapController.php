<?php 
namespace App\Controllers;
class RoadMapController
{
    public function roadmap(){
        
            render('developer_interface/gui_roadmap',[],'layouts/main_layout');
    }
}