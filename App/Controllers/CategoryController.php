<?php 
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Services\CategoryService;
use App\HTMLRenderer\Layout;
class CategoryController extends BaseController
{
    private $categoryService;
    private $mainCateModel;
    private $subCateModel;
    public function __construct(){
        $this->mainCateModel=new MainCategory();
        $this->subCateModel=new SubCategory();
        $this->categoryService=new CategoryService($this->mainCateModel,$this->subCateModel);
                     $navbar =dashboardnavbar();
         $sidebar = isLoggedIn()?dashboardsidebar():null;

        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'اعلام عرضه یا تقاضا',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);
    }


     public function allCategories(){
        $categories=$this->categoryService->getAllMainCategories();
        // $statistics=$this->categoryService->getCategoryStatistics()['mainCategoryStatistics'];
        
        $this->render('categories/all_categories',['categories'=>$categories],[]);
    }

public function showMainCategory($id)
{
    $mainCategory = $this->categoryService->getMainCategory($id);
    $subCategories = $this->categoryService->getSubCategoriesByMainCategory($id);
    $allMainCategories = $this->categoryService->getAllMainCategories();

    $this->render('categories/show_category', [
        'main_category' => $mainCategory,
        'sub_categories' => $subCategories,
        'main_categories' => $allMainCategories
    ]);
}


   public function storeMainCategory() {
    // CSRF check
    if (!csrf('verify', $_POST['_token'])) {
        setTemporarySession('csrf', 'error', 'نشانه امنیتی (CSRF token) نامعتبر است.');
        redirect(route('ietcategories.all'));
        return;
    }

    // Optionally validate required fields
    if (empty($_POST['cate_name'])) {
        setTemporarySession('emptyRequiredField', 'error', 'عنوان دسته‌بندی نمی‌تواند خالی باشد.');
        redirect(route('ietcategories.all'));
        return;
    }

$data = array_diff_key($_POST, ['_token' => true]);
        // Save to database
    try {
       $this->categoryService->createMainCategory($data);
        setTemporarySession('storeData', 'success', 'دسته‌بندی با موفقیت ایجاد شد.');
        redirect(route('ietcategories.all'));
    } catch (\Exception $e) {
        setTemporarySession('storeData', 'error', 'در هنگام ایجاد دسته‌بندی مشکلی رخ داد.');
        redirect(route('ietcategories.all'));
    }

}


public function storeSubCategory() {
    // Verify POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        setTemporarySession('requestMethod', 'error', 'Invalid request method.');
        redirect(route('ietcategories.all'));
        return;
    }

    // CSRF protection
    if (!isset($_POST['_token']) || !csrf('verify', $_POST['_token'])) {
        setTemporarySession('csrf', 'error', 'Invalid security token.');
        redirect(route('ietcategories.show_main', ['id' => $_POST['main_cate_id'] ?? '']));
        return;
    }

    // Validate required fields
    $required = ['cate_name', 'main_cate_id'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            setTemporarySession('validation', 'error', "Please fill all required fields.");
            redirect(route('ietcategories.show_main', ['id' => $_POST['main_cate_id'] ?? '']));
            return;
        }
    }

    // Prepare data
    $data = [
        'cate_name' => trim($_POST['cate_name']),
        'main_cate_id' => (int)$_POST['main_cate_id'],
        'key_words' => !empty($_POST['key_words']) ? trim($_POST['key_words']) : null,
        'description' => !empty($_POST['description']) ? trim($_POST['description']) : null
    ];

    // Database operation
    try {
        $result = $this->categoryService->createSubCategory($data);
        
        if ($result) {
            $_SESSION['success']='sietSays:دسته بندی با موفقیت افزوده شد';
        } else {
            setTemporarySession('error', 'error', 'Failed to create subcategory.');
        }
    } catch (\Exception $e) {
        setTemporarySession('error', 'error', 'Error: ' . $e->getMessage());
    }

    // Always redirect back to the main category view
    redirect(route('ietcategories.show_main', ['id' => $data['main_cate_id']]));
}

    public function deleteMainCategory($id) {
        try {
            $this->categoryService->deleteMainCategory($id);
            setTemporarySession('deleteData', 'success', 'دسته‌بندی با موفقیت حذف شد.');
        } catch (\Exception $e) {
            setTemporarySession('deleteData', 'error', 'در هنگام حذف دسته‌بندی مشکلی رخ داد.');
        }
        redirect(route('ietcategories.all'));
    }

public function deleteSubCategory($id) {
    // Verify POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error']='not Post method';
        redirect(route('ietcategories.all'));
        return;
    }

    // CSRF protection
    if (!isset($_POST['_token']) || !csrf('verify', $_POST['_token'])) {
        $_SESSION['error']='csrf problem';
        redirect(route('ietcategories.show_main', ['id' => $_POST['main_category_id'] ?? '']));
        return;
    }

    try {
        $mainCategoryId = $_POST['main_category_id'] ?? null;
        $success = $this->categoryService->deleteSubCategory($id);
        
        if ($success) {
            $_SESSION['success']='DeletedSuccessfully';
        } else {
             $_SESSION['error']='store problem';
        }
        
        // Redirect back to where the delete was initiated from
        if ($mainCategoryId) {
            redirect(route('ietcategories.show_main', ['id' => $mainCategoryId]));
        } else {
            redirect(route('ietcategories.all'));
        }
        
    } catch (\Exception $e) {
        $_SESSION['error']='Error deleting subcategory: ' . $e->getMessage();
        redirect(route('ietcategories.all'));
    }
}
    
}