<?php

function dashboard_sidebar(){
    return[
            'items'=>[
                
                    ['label'=>'اعلام ها','href'=>route('ietannounce.create')],
                    ['label'=>'مقاله ها','href'=>route('ietannounce.mine')],
                    ['label'=>'گفتگوها','href'=>route('ietannounce.mine')],
            ]
            ];

            }