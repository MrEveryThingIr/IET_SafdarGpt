<?php
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;

        $navbar = new Navbar([
            'brand' => ['label'=>'IET System','href'=>route('iethome')],
            'items' => [
                ['label' => 'مشخصات فردی', 'href' => route('user.profile',['feature'=>'identification']),'class'=>'bg-blue-600 m-2 hover:bg-blue-700 text-white px-4 py-2 rounded transition'],
                ['label'=>'تحصیلات','href'=>"#",'class'=>'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition'],
                ['label' => 'مشخصات شغلی', 'href' => '#','class'=>'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition'],
                ['label' => 'مهارت های جانبی', 'href' => '#','class'=>'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition'],
                ['label' => 'نیازهای دوره ای', 'href' => '#','class'=>'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition'],
                ['label' => 'اعلام ها', 'href' => route('user.profile',['feature'=>'my_announces']),'class'=>'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition'],

            ]
        ]);

        $sidebar = new Sidebar([
            'items' => [
                ['label' =>' بروزرسانی پروفایل' , 'href' => route('ietannounce.create')],
                ['label' => 'افزودن ویژگی', 'href' => route('ietannounce.mine')],
                // ['label' => '', 'href' => route('ietannounce.all')],
            ]
        ]);

       echo $navbar->render();
switch($feature){
    case 'identification':
        include views_path('auth/profile/identification.php');
        break;
    case 'my_announces':
        include views_path('iet_announce/mine.php');
        break;
    case 'education_and_honors':
        include views_path('auth\profile\honors\education_and_honors.php');
        break;
    
}


