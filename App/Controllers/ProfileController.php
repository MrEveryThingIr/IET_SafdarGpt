<?php 
namespace App\Controllers;

use App\Core\BaseController;
use App\HTMLRenderer\Layout;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\Models\IETAnnounce;
use App\Models\IETAnnounceComment;
use App\Services\IETAnnounceService;
use App\Services\CategoryService;
use App\Services\ArticleService;
use App\Models\SubCategory;
use App\models\MainCategory;
use App\Services\ChatService;

use App\Models\User;

class ProfileController extends BaseController
{
    private $mainCategory;
    
    private $subCategory;
    private $categoryService;
    private $chatService;
    private $ietAnnounceService;
    private $ietArticleService;
    private $ietAnnounceModel;
    private $ietAnnounceCommentModel;
    public function __construct(){
        $this->mainCategory=new MainCategory();
        $this->subCategory=new SubCategory();
        $this->categoryService=new CategoryService($this->mainCategory,$this->subCategory);
        $this->ietArticleService=new ArticleService();
        $this->ietAnnounceService=new IETAnnounceService();
        $this->chatService=new ChatService();
        isLoggedIn();
        
        $sidebar=profileSidebar();
        $navbar =dashboardnavbar();
        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'پروفایل',
            'template' => 'layouts/main_layout',
            'scriptsPaths' => ['assets/js/temporary/profile.js'] // method-level override
        ]);
    }
public function center($feature, $user_id = 1)
{
    $data = [];

    switch ($feature) {
        case 'my_announces':
            $data = $this->ietAnnounceService->getAnnouncesByUserId($user_id);
            break;

        case 'my_supplies':
            $supplies=$this->ietAnnounceService->getAnnouncesByUserWithFilters($_SESSION['user_id'],['supply_demand'=>'supply']);
                foreach($supplies as &$supply){
                    $cateNames=$this->categoryService->findMainSubCateBySubId($supply['sub_category_id']);
                $supply['main_sub_cate_name'] = $cateNames['main_category_name'] . ' / ' . $cateNames['sub_category_name'];
                }
            
            $data['my_supplies'] = $supplies;
            break;

        case 'my_demands':
            $demands=$this->ietAnnounceService->getAnnouncesByUserWithFilters($_SESSION['user_id'],['supply_demand'=>'demand']);

            // Enrich each demand with main + sub category names
            foreach ($demands as &$demand) {
                $cateNames = $this->categoryService->findMainSubCateBySubId($demand['sub_category_id']);
                $demand['main_sub_cate_name'] = $cateNames['main_category_name'] . ' / ' . $cateNames['sub_category_name'];
            }

            $data['my_demands'] = $demands;
            break;

        case 'my_articles':
            $my_articles=$this->ietArticleService->getArticlesOfAUserId($_SESSION['user_id']);
            foreach($my_articles as &$my_article){
             $cateNames = $this->categoryService->findMainSubCateBySubId($my_article['field_category_id']);
             $my_article['main_sub_cate_name'] = $cateNames['main_category_name'] . ' / ' . $cateNames['sub_category_name'];
            }
            $data['my_articles']=$my_articles;
            break;

case 'my_chatrooms':

    // Fetch categorized chatrooms for user
    $my_chatrooms = $this->chatService->getChatRoomsByUser($_SESSION['user_id']);

    // Enrich created chatrooms with category names
    foreach ($my_chatrooms['chatrooms_created'] as &$chatroom) {
        if (!empty($chatroom['category_id'])) {
            $cateNames = $this->categoryService->findMainSubCateBySubId($chatroom['category_id']);
            $chatroom['main_sub_cate_name'] = $cateNames['main_category_name'] . ' / ' . $cateNames['sub_category_name'];
        } else {
            $chatroom['main_sub_cate_name'] = '---';
        }
    }

    // Enrich joined chatrooms with category names
    foreach ($my_chatrooms['chatrooms_joined'] as &$chatroom) {
        if (!empty($chatroom['category_id'])) {
            $cateNames = $this->categoryService->findMainSubCateBySubId($chatroom['category_id']);
            $chatroom['main_sub_cate_name'] = $cateNames['main_category_name'] . ' / ' . $cateNames['sub_category_name'];
        } else {
            $chatroom['main_sub_cate_name'] = '---';
        }
    }

    // Fetch all main categories
    $mainCategories = $this->categoryService->getAllMainCategories();

    // Fetch subcategories grouped by main category ID
    $subCategories = [];
    foreach ($mainCategories as $mainCategory) {
        $subCategories[$mainCategory['id']] = $this->categoryService->getMainCategoryWithSubCategories($mainCategory['id']);
    }

    // Pass to view
    $data['my_chatrooms'] = $my_chatrooms;
    $data['mainCategories'] = $mainCategories;
    $data['sub_categories'] = $subCategories;

    break;

        case 'education_and_honors':
            $data = [];
            break;

        default:
            $user = new User();
            $user->id = $user_id;
            $data['user_info'] = $user->fetchUserById();
            $data['userAge'] = $user->getUserAge($user_id);
            break;
    }

    $this->render('auth/profile/center', ['feature' => $feature, 'data' => $data], []);
}

}