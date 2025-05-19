<?php
use App\HTMLRenderer\Sidebar;

function dashboardsidebar(): Sidebar {
    if(isLoggedIn()){
         $sidebar = [];

    $user = user();

    $sidebar = sidebar_add_header(
        $sidebar,
        $user,
        $user['balance'] ?? '0',
        $user['bio'] ?? 'همه چیز برای همه، همه برای هم',
        'mb-4 p-4 bg-blue-100 rounded text-gray-800'
    );

    $sidebar = sidebar_add_item($sidebar, 'اعلام ها', null, route('ietannounce.all'), '', '📊', true);
    $sidebar = sidebar_add_item($sidebar, 'مقاله ها', null,  route('ietarticles.all'), '', '📈');
    $sidebar = sidebar_add_item($sidebar, 'گروهها و گفتگوها', null, route('ietchats.room.all'), '', '⚙️');
    if($user['username']=='SMSchrodinger'){
         $sidebar = sidebar_add_item($sidebar, 'دسته بندیها', null, route('ietcategories.all'), '');
    }
 

    $sidebar = sidebar_set_style($sidebar, 'w-64 bg-blue-400 text-white h-full p-4');

    return new Sidebar($sidebar);
    }else{
        return home_sidebar();
    }
   
}

function chatroomSidebar($members_list=[]){
        $sidebar = [];

    $user = user();

    $sidebar = sidebar_add_header(
        $sidebar,
        $user,
        $user['balance'] ?? '0',
        $user['bio'] ?? 'همه چیز برای همه، همه برای هم',
        'mb-4 p-4 bg-blue-100 rounded text-gray-800'
    );
    
    $sidebar = sidebar_add_item($sidebar, 'بازگشت', 1, route('dashboard'), '', '📊', true);
    foreach($members_list as $member){
        
    $sidebar = sidebar_add_item($sidebar, user($member['invited_user_id'])['username'], null, '#', '', '📊');
    }
     $sidebar = sidebar_set_style($sidebar, 'w-64 bg-blue-400 text-white h-full p-4');

    return new Sidebar($sidebar);
}

function home_sidebar(): Sidebar {
    $sidebar = [];

    if (isLoggedIn()) {
        $user = user();
        $sidebar = sidebar_add_header($sidebar, $user, $user['balance'] ?? '0', $user['bio'] ?? '');
        $sidebar = sidebar_add_item($sidebar, 'Profile', null, '#', '', '👤');
        $sidebar = sidebar_add_item($sidebar, 'Logout', null, '#', 'text-red-400 hover:bg-red-800', '🚪');
    } else {
        $sidebar = sidebar_add_item($sidebar, 'Login', null, '#', 'bg-green-700 text-white', '🔐', true);
        $sidebar = sidebar_add_item($sidebar, 'Register', null, '#', '', '📝');
    }

    $sidebar = sidebar_add_item($sidebar, 'Home', null, '#', '', '🏠');
    $sidebar = sidebar_add_item($sidebar, 'About', null, '#', '', 'ℹ️');

    $sidebar = sidebar_set_style($sidebar, 'w-64 bg-gray-800 text-white p-4');

    return new Sidebar($sidebar);
}


function admin_sidebar(): Sidebar {
    $sidebar = [];

    $user = user();
    $sidebar = sidebar_add_header($sidebar, $user, '∞', 'Administrator');

    $sidebar = sidebar_add_item($sidebar, 'Dashboard', null, '#', '', '🧭', true);
    $sidebar = sidebar_add_item($sidebar, 'Users', null, '#', '', '👥');
    $sidebar = sidebar_add_item($sidebar, 'Logs', null, '#', '', '📜');
    $sidebar = sidebar_add_item($sidebar, 'Settings', null, '#', '', '⚙️');
    $sidebar = sidebar_add_item($sidebar, 'Logout', null, '#', 'text-red-400 hover:bg-red-800', '🚪');

    $sidebar = sidebar_set_style($sidebar, 'w-64 bg-gray-950 text-white p-4');

    return new Sidebar($sidebar);
}


function articleSidebar($article): Sidebar
{
    if (!isLoggedIn()) {
        return home_sidebar(); // fallback
    }

    if (!$article) {
        die("Invalid article");
    }

    $user = user();
    $sidebar = [];

    $meta = implode('<br>', [
        '📄 ' . htmlspecialchars($article['title']),
        '✍️ ' . htmlspecialchars($user['username']),
        '🕒 ' . ($article['created_at'] ?? ''),
        '📌 ' . ($article['status'] ?? 'draft'),
    ]);

    // Sidebar Header
    $sidebar = sidebar_add_header(
        $sidebar,
        $user,
        $user['balance'] ?? '0',
        $meta,
        'mb-4 p-4 bg-white shadow rounded text-gray-700'
    );

    // Action Items
    $modalItems = [
        [' Add Paragraph', 1, '#addParagraphModal', '📝'],
        [' Add Heading', 2, '#addHeadingModal', '🔠'],
        [' Add Image', 3, '#addImageModal', '🖼️'],
        [' Add Audio', 4, '#addAudioModal', '🎵'],
        [' Add Video', 5, '#addVideoModal', '🎥'],
        [' Add List', 6, '#addListModal', '📋'],
        [' Add Quote', 7, '#addQuoteModal', '💬'],
        [' Add Divider', 8, '#addDividerModal', '➖'],
        [' Add Embed', 9, '#addEmbedModal', '🌐'],
        [' Add CTA', 10, '#addCtaModal', '📌'],
        [' Add FAQ', 11, '#addFaqModal', '❓'],
        [' Add Section (Heading + Paragraph)', 12, '#addSectionModal', '📚'],
        [' Set Styles', 13, '#setStylesModal', '🎨'],
    ];

 
        foreach ($modalItems as [$label, $index, $href, $icon]) {
            $triggerId = 'trigger_' . ltrim($href, '#');

            $sidebar = sidebar_add_item(
                $sidebar,
                $label,
                $index,
                $href,
                '',
                $icon,
                false,
               ['id' => $triggerId, 'data-modal' => $href]
            );
    }

    // Preview and Delete
    $sidebar = sidebar_add_item(
        $sidebar,
        ' Preview Article',
        14,
        route('ietchats.room.show'), // ✔️ fixed from 'all'
        '',
        '🔍'
    );

    $sidebar = sidebar_add_item(
        $sidebar,
        ' Delete Article',
        15,
        route('ietchats.room.show'), // ✔️ corrected route
        'text-red-500 hover:bg-red-600 hover:text-white',
        '⚠️',
        false,
        ['onclick' => 'return confirm("Are you sure you want to delete this article?")']
    );

    // Final style
    $sidebar = sidebar_set_style($sidebar, 'w-72 bg-indigo-300 text-white flex flex-col max-h-screen overflow-y-auto');

    return new Sidebar($sidebar);
}
