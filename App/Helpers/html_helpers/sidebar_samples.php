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
    
    $sidebar = sidebar_add_item($sidebar, 'بازگشت', 1, route('user.profile',['feature'=>'my_chatrooms','user_id'=>user()['id']]), '', '📊', true);
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
    $sidebar = sidebar_add_item($sidebar, 'بازگشت', 1, route('user.profile',['feature'=>'my_articles','user_id'=>user()['id']]), '', '📊', true);

    // Action Items
    $modalItems = [
        [' Add Paragraph', 2, '#addParagraphModal', '📝'],
        [' Add Heading', 3, '#addHeadingModal', '🔠'],
        [' Add Image', 4, '#addImageModal', '🖼️'],
        [' Add Audio', 5, '#addAudioModal', '🎵'],
        [' Add Video', 6, '#addVideoModal', '🎥'],
        [' Add List', 7, '#addListModal', '📋'],
        [' Add Quote', 8, '#addQuoteModal', '💬'],
        [' Add Divider', 9, '#addDividerModal', '➖'],
        [' Add Embed', 10, '#addEmbedModal', '🌐'],
        [' Add CTA', 11, '#addCtaModal', '📌'],
        [' Add FAQ', 12, '#addFaqModal', '❓'],
        [' Add Section (Heading + Paragraph)', 13, '#addSectionModal', '📚'],
        [' Set Styles', 14, '#setStylesModal', '🎨'],
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
        15,
        route('ietchats.room.show'), // ✔️ fixed from 'all'
        '',
        '🔍'
    );

$sidebar = sidebar_add_form_item(
    $sidebar,
    'حذف مقاله',
    route('ietarticles.delete_article', ['id' => $article['id']]),
    16, // index (optional)
    'text-red-500 hover:bg-red-600 hover:text-white',
    '⚠️'
);




    // Final style
    $sidebar = sidebar_set_style($sidebar, 'w-72 bg-indigo-300 text-white flex flex-col max-h-screen overflow-y-auto');

    return new Sidebar($sidebar);
}



function profileSidebar(): Sidebar
{
    if (!isLoggedIn()) {
        return home_sidebar(); // fallback for unauthorized users
    }

    $user = user();
    $sidebar = [];

    // Sidebar Header
    $meta = implode('<br>', [
        '👤 ' . htmlspecialchars($user['full_name'] ?? 'User'),
        '📧 ' . htmlspecialchars($user['email'] ?? 'No email'),
        '🕒 Last Login: ' . htmlspecialchars($user['last_login'] ?? 'Unknown')
    ]);

    $sidebar = sidebar_add_header(
        $sidebar,
        $user,
        $user['balance'] ?? '0',
        $meta,
        'mb-4 p-4 bg-white shadow rounded text-gray-700'
    );

    // Back button
    $sidebar = sidebar_add_item(
        $sidebar,
        'بازگشت', // Back
        1,
        route('dashboard'),
        '',
        '🔙',
        true
    );

    // Profile-related Items
    $profileItems = [
        ['مشخصات فردی', 2, route('user.profile',['feature'=>'identification','user_id'=>user()['id']]), '📋'],
        // ['مشخصات تحصیلی', 3,'#', '🎓'],
        // ['مشخصات شغلی', 4, '#', '💼'],
        ['عرضه های من', 5,  route('user.profile',['feature'=>'my_supplies','user_id'=>user()['id']]), '📌'],
        ['تقاضاهای من', 6, route('user.profile',['feature'=>'my_demands','user_id'=>user()['id']]), '🛠️'],
        // ['علاقمندیهای من', 7, '#', '❤️'],
        ['مقاله‌های من', 8, route('user.profile',['feature'=>'my_articles','user_id'=>user()['id']]), '📄'],
        ['گروهها و گفتگوهای من', 9, route('user.profile',['feature'=>'my_chatrooms','user_id'=>user()['id']]), '📄'],
        ['دسته بندیهای من', 10, route('ietcategories.all'), '📄'],
    ];

    foreach ($profileItems as [$label, $index, $href, $icon]) {
        $sidebar = sidebar_add_item(
            $sidebar,
            $label,
            $index,
            $href,
            '',
            $icon,
            false
        );
    }

    // Final style
    $sidebar = sidebar_set_style($sidebar, 'w-72 bg-indigo-300 text-white flex flex-col max-h-screen overflow-y-auto');

    return new Sidebar($sidebar);
}