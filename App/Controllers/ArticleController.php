<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Services\ArticleService;
use App\Services\CategoryService;
use App\HTMLRenderer\Layout;
class ArticleController extends BaseController
{
    private $categoryService;
    private $mainCateModel;
    private $subCateModel;
    private $articleService;
    public function __construct(){
        $this->articleService=new ArticleService();
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

       public function createArticleBlockForm(){
        
        $this->render('articles/add_article_block',[],[]);
    }
     public function allArticles(){
        $articles=$this->articleService->listArticles();
        $this->render('articles/all',['articles'=>$articles],[]);
    }

public function showArticle($id)
{
    $article = $this->articleService->getArticleWithBlocks($id);

    $builder = (new \App\HTMLRenderer\ArticleBuilder())
        ->withArticleData($article)
        ->withHeadings()
        ->withParagraphs()
        ->withImages()
        ->withLists();

   $this->render('articles/show_article',['article'=>$builder],[]);
}


    // public function storeArticle() {
    //     $this->articleService->    ???
    // }


}