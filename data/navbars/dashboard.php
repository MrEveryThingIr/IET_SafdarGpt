<?php
function dashboard_navbar($user=[]){
    return [
        'brand'=>'IET System',
        'items'=>[
            [
                'label' => $user['firstname'] . ' ' . $user['lastname'],
                'href' => route('user.profile',['feature'=>'identification','user_id'=>$user['id']]),
                'class' => 'flex items-center gap-2 text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium',
                'icon' => '<img src="' . $user['img'] . '" class="w-8 h-8 rounded-full object-cover">',
            ],
     
            ['label'=>'خانه','href'=>route('iethome'),'class'=>'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2'],
            
            [
                'label' => 'خروج',
                'form' => true, // Flag to indicate this is a form
                'action' => route('auth.logout'),
                'class' => 'bg-green-700 m-1 text-white text-lg font-semibold rounded-md p-2',
                'method' => 'POST'
            ],   
        ]
        ];
}
