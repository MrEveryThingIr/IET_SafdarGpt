<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Services\ArticleService;
use App\Services\CategoryService;
use App\HTMLRenderer\Layout;
use App\Helpers\UploadFile;
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

    public function allArticles(): void
    {
        $articles = $this->articleService->listLatest(50); // Fetch latest 50 articles

        $this->render('articles/all', [
            'articles' => $articles
        ], []);
    }


public function showArticle(int $id): void
{
    $article = $this->articleService->getFullArticleWithSections($id);
    $navbar = dashboardnavbar();
    $sidebar = isLoggedIn() ? articleSidebar($article) : null;

    $this->layout = new Layout($navbar, $sidebar, [
        'title' => 'اعلام عرضه یا تقاضا',
        'template' => 'layouts/main_layout',
        'stylesPaths'=>[],
        'scriptHelpers' => ['modalTriggers'], // <<< Important: attach modal triggers here
    ]);

    if (!$article) {
        http_response_code(404);
        echo "Article not found.";
        return;
    }

    $this->render('articles/show_article', [
        'article' => $article,
        'sections' => $article['structured_blocks'] ?? []
    ]);
}



    public function storeArticle(): void
    {
        // Ensure it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Invalid request method.';
            redirect(route('articles.create_form'));
            return;
        }

        // CSRF protection
        if (!isset($_POST['_token']) || !csrf('verify', $_POST['_token'])) {
            $_SESSION['error'] = 'Invalid CSRF token.';
            redirect(route('articles.create_form'));
            return;
        }

        try {
            $data = [
                'title'         => trim($_POST['title'] ?? ''),
                'slug'          => trim($_POST['slug'] ?? ''),
                'author_id'     => $_POST['author_id'] ?? ($_SESSION['user']['id'] ?? null),
                'status'        => $_POST['status'] ?? 'draft',
                'language_code' => $_POST['language_code'] ?? 'en',
                'created_at'    => date('Y-m-d H:i:s'),
            ];

            if (empty($data['title']) || !$data['author_id']) {
                $_SESSION['error'] = 'Title and author are required.';
                redirect(route('articles.create_form'));
                return;
            }

            $articleId = $this->articleService->createArticle($data);
            $_SESSION['success'] = 'Article created successfully.';
            redirect(route('articles.edit', ['id' => $articleId]));
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Failed to create article: ' . $e->getMessage();
            redirect(route('articles.create_form'));
        }
    }

public function storeArticleBlock(): void
{
    $articleId = (int) $_POST['article_id'];
    $blockType = $_POST['block_type'];
    // Ensure it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'Invalid request method.';
        redirect(route('ietarticle.show_article',['id'=>$articleId]));
        return;
    }

    // CSRF protection
    if (!isset($_POST['_token']) || !csrf('verify', $_POST['_token'])) {
        $_SESSION['error'] = 'Invalid security token.';
       redirect(route('ietarticle.show_article',['id'=>$articleId]));
        return;
    }

    // Validate required base fields
    if (empty($_POST['article_id']) || empty($_POST['block_type'])) {
        $_SESSION['error'] = 'Missing article ID or block type.';
       redirect(route('ietarticle.show_article',['id'=>$articleId]));
        return;
    }

    // Collect allowed fields based on block type
    $data = [
        'block_type' => $blockType,
        'content' => $_POST['content'] ?? null,
        'css_class' => $_POST['css_class'] ?? null,
        'language_code' => $_POST['language_code'] ?? 'en',
    ];

    // Handle type-specific fields
    switch ($blockType) {
        case 'heading':
            $data['heading_level'] = isset($_POST['heading_level']) ? (int) $_POST['heading_level'] : null;
            break;

        case 'image':
            $data['image_url'] = $_POST['image_url'] ?? null;
            $data['image_alt'] = $_POST['image_alt'] ?? null;
            $data['image_caption'] = $_POST['image_caption'] ?? null;

            // If file uploaded, override image_url
            if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $upload = UploadFile::uploadFromArray('image', $_FILES['file']);
                if ($upload['success']) {
                    $data['image_url'] = $upload['url'];
                } else {
                    $_SESSION['error'] = 'Image upload failed: ' . $upload['error'];
                    redirect(route('ietarticle.show_article',['id'=>$articleId]));
                    return;
                }
            }
            break;

        case 'audio':
        case 'video':
            if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $category = $blockType;
                $upload = UploadFile::uploadFromArray($category, $_FILES['file']);
                if ($upload['success']) {
                    $data['content'] = $upload['url'];
                } else {
                    $_SESSION['error'] = ucfirst($blockType) . ' upload failed: ' . $upload['error'];
                    redirect(route('ietarticle.show_article',['id'=>$articleId]));
                    return;
                }
            }
            break;

        case 'list':
            $data['list_type'] = $_POST['list_type'] ?? 'unordered';
            break;

        case 'cta':
        case 'faq':
        case 'section':
            $data['additional_data'] = json_encode($_POST['additional_data'] ?? []);
            break;
    }

    // Call the service to store the block
    try {
        $service = $this->articleService;

        if ($blockType === 'section') {
            $heading = $_POST['additional_data']['heading'] ?? '';
            $paragraph = $_POST['additional_data']['paragraph'] ?? '';
            $headingLevel = (int) ($_POST['additional_data']['heading_level'] ?? 2);
            $service->addContentSection($articleId, $heading, $paragraph, $headingLevel);
        } else {
            $service->addBlock($articleId, $data);
        }

        $_SESSION['success'] = 'Block added successfully.';
    } catch (\Exception $e) {
        $_SESSION['error'] = 'Failed to add block: ' . $e->getMessage();
    }

    redirect(route('ietarticle.show_article',['id'=>$articleId]));
}




}