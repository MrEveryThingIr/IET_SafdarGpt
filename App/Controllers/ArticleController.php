<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Services\CategoryService;
use App\HTMLRenderer\Layout;
class ArticleController extends BaseController
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
    public function createArticleForm(){
        $categories=$this->categoryService->getAllSubCategories();
        $this->render('articles/create_article',['categories'=>$categories],[]);
    }

     public function allArticles(){
        $this->render('articles/all',[],[]);
    }
}