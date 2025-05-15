<?php 
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    private $categoryService;
    private $mainCateModel;
    private $subCateModel;
    public function __construct(){
        $this->mainCateModel=new MainCategory();
        $this->subCateModel=new SubCategory();
        $this->categoryService=new CategoryService($this->mainCateModel,$this->subCateModel);
    }

    public function createMainCategoryForm(){
        $this->render('categories/create_main',[],[]);
    }
}