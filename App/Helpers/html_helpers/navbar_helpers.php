<?php
declare(strict_types=1);
function modal($content,$modal_id='the_modal',$more_options=[]){
    echo "  
         <div id=\"$modal_id\" 
             class=\"fixed inset-0 z-50 hidden bg-black bg-opacity-50\">
          <div class=\"modal-content absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg w-full max-w-md\">
            <button class=\"close absolute top-2 right-2 text-2xl\">&times;</button>
            $content
          </div>
        </div>";
}

function add_navbar_brand(array $navbar, string $label, string $href = "#", string $class = ''): array {
    $navbar['brand'] = [
        'label' => $label,
        'href' => $href,
        'class' => $class ?: 'text-2xl font-bold text-gray-800 hover:text-blue-600'
    ];
    return $navbar;
}

function add_navbar_item(array $navbar, string $label, string $href = '#', string $class = '', int $n = null): array {
    $item = [
        'label' => $label,
        'href'  => $href,
        'class' => $class ?: 'text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium'
    ];
    if (is_null($n)) {
        $navbar['items'][] = $item;
    } else {
        $navbar['items'][$n] = $item;
    }
    return $navbar;
}

function add_navbar_form_button(array $navbar, string $label, string $action, string $method = 'POST', string $class = ''): array {
    $navbar['items'][] = [
        'label'  => $label,
        'form'   => true,
        'action' => $action,
        'method' => $method,
        'class'  => $class ?: 'm-1 px-4 py-2 bg-red-600 text-white text-lg font-semibold rounded-md hover:bg-red-700 transition-colors'
    ];
    return $navbar;
}

function add_navbar_user_profile(array $navbar, array $user, string $class = ''): array {
    $navbar['items'][] = [
        'label' => $user['firstname'] . ' ' . $user['lastname'],
        'href'  => route('user.profile', ['feature' => 'identification', 'user_id' => $user['id']]),
        'icon'  => '<img src="' . $user['img'] . '" class="w-8 h-8 rounded-full object-cover">',
        'class' => $class ?: 'flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors'
    ];
    return $navbar;
}


function navbar_dark_theme(array $navbar): array {
  $navbar['class'] = 'bg-gray-900 text-white';
  return $navbar;
}

function navbar_light_theme(array $navbar): array {
  $navbar['class'] = 'bg-white text-gray-800';
  return $navbar;
}
