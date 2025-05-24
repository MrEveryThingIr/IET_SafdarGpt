<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Services\IETAnnounceService;
use App\Services\CategoryService;
use App\Models\SubCategory;
use App\models\MainCategory;
use App\Helpers\UploadFile;
use App\HTMLRenderer\Layout;
use Exception;

class IETAnnounceController extends BaseController
{
    private IETAnnounceService $announceService;
    private $mainCateModel;
    private $subCateModel;
    private $categoryService;

    public function __construct()
    {
        $navbar = dashboardnavbar();
        $sidebar = isLoggedIn() ? profileSidebar() : null;
        $this->mainCateModel=new MainCategory();
        $this->subCateModel=new SubCategory();
        $this->categoryService=new CategoryService($this->mainCateModel,$this->subCateModel);

$this->layout = new Layout($navbar, $sidebar, [
    'title' => 'اعلام عرضه یا تقاضا',
    'template' => 'layouts/main_layout',
    'scriptsPaths' => [
        ['src' => 'assets/js/temporary/ietannouncecreate.js', 'type' => 'module']
    ]
]);

        $this->announceService = new IETAnnounceService();
    }

public function create(string $sd = ''): void
{
    // Fetch all main categories
    $mainCategories = $this->categoryService->getAllMainCategories();

    // Fetch subcategories grouped by main category ID
    $subCategories = [];
    foreach ($mainCategories as $mainCategory) {
        $subCategories[$mainCategory['id']] = $this->categoryService->getMainCategoryWithSubCategories($mainCategory['id']);
    }

    // Render view with category data
    $this->render('iet_announce/create', [
        'sd' => $sd,
        'categories' => [
            'main' => $mainCategories,
            'sub' => $subCategories,
        ]
    ]);
}

/**
 * Store a new announcement.
 */
public function store($sd = ''): void
{
    try {
        // CSRF validation
        if (!csrf('verify', $_POST['_token'] ?? null)) {
            throw new Exception('CSRF validation failed');
        }

        // Ensure user is logged in
        if (empty($_SESSION['user_id'])) {
            throw new Exception('کاربر وارد نشده است');
        }

        // Validate required fields
        $requiredFields = ['supply_demand', 'goods_services', 'title'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("فیلد $field الزامی است");
            }
        }

        // Handle media uploads
        $mediaUrls = $this->handleMediaUploads();

        // Prepare data for the announcement
        $data = [
            'user_id' => $_SESSION['user_id'],
            'supply_demand' => $_POST['supply_demand'],
            'goods_services' => $_POST['goods_services'],
            'sub_category_id' => $_POST['sub_category_id'] ?? null,
            'title' => $_POST['title'],
            'description' => $_POST['description'] ?? '',
            'unit' => $_POST['unit'] ?? '',
            'initial_suggested_price' => $_POST['initial_suggested_price'] ?? null,
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
            'location_limit' => $_POST['location_limit'] ?? '',
            'media_paths' => json_encode($mediaUrls),
        ];

        // Save the announcement
        $created = $this->announceService->createAnnounce($data);

        if ($created) {
            $_SESSION['success'] = "اعلام با موفقیت ثبت شد";

            // Redirect to user's announcement list
            if ($sd === 'supply') {
                redirect( route('user.profile',['feature'=>'my_supplies','user_id'=>$_SESSION['user_id']]));
            } elseif ($sd === 'demand') {
                redirect( route('user.profile',['feature'=>'my_demands','user_id'=>$_SESSION['user_id']]));
            } else {
                redirect(route('user.profile', [
                     'feature' => 'my_announces',
                    'user_id' => $_SESSION['user_id'],
                   
                ]));
            }
        } else {
            throw new Exception("خطا در ثبت اعلام");
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect(route('ietannounce.create', ['sd' => $sd ?: 'notdefined']));
    }
}


    /**
     * Display the user's announcements.
     */
    public function mine(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        $announces = $this->announceService->getAnnouncesByUserId($userId);
        $this->render('iet_announce/mine', ['announces' => $announces]);
    }

    /**
     * Display all announcements.
     */
    public function allAnnounces(): void
    {
        $allAnnounces = $this->announceService->getAllAnnounces();
        $this->render('iet_announce/all', ['announces' => $allAnnounces]);
    }

    /**
     * Display filtered announcements.
     */
    public function filteredAnnounces(string $filter): void
    {
        $keywords = $this->getKeywordsByFilter($filter);
        $supplyDemand = in_array($filter, ['supply', 'demand']) ? $filter : '';
        $goodsServices = in_array($filter, ['goods', 'services']) ? $filter : '';

        $filtered = $this->announceService->filterAnnounces($supplyDemand, $keywords, $goodsServices);
        $this->render('iet_announce/all', ['announces' => $filtered]);
    }

    /**
     * Show a specific announcement with comments.
     */
public function show(int $id): void
{
    $announce = $this->announceService->getAnnounceById($id);
    if (!$announce) {
        $this->render('errors/404');
        return;
    }

    // Resolve full category name
  
    $cateNames = $this->categoryService->findMainSubCateBySubId($announce['sub_category_id']);
    $announce['category'] = $cateNames['main_category_name'] . ' / ' . $cateNames['sub_category_name'];

    // Translate supply_demand and goods_services
    $announce['supply_demand_label'] = $announce['supply_demand'] === 'supply' ? 'عرضه' : 'تقاضا';
    $announce['goods_services_label'] = $announce['goods_services'] === 'goods' ? 'کالا' : 'خدمات';

    $comments = $this->announceService->getCommentsByAnnounceId($id);

    $this->render('iet_announce/show', [
        'announce' => $announce,
        'comments' => $comments
    ]);
}


    /**
     * Show the form to edit an announcement.
     */
    public function edit(int $id): void
    {
        $announce = $this->announceService->getAnnounceById($id);
        if (!$announce) {
            $this->render('errors/404');
            return;
        }

        $mediaUrls = json_decode($announce['media_paths'], true) ?? [];
        $this->render('iet_announce/edit', [
            'announce' => $announce,
            'mediaUrls' => $mediaUrls,
            'existingMediaJs' => json_encode($mediaUrls),
        ], ['filePreview', 'existingMedia']);
    }

    /**
     * Update an existing announcement.
     */
    public function update(int $id): void
    {
        try {
            $existing = $this->announceService->getAnnounceById($id);
            if (!$existing) {
                $this->render('errors/404');
                return;
            }

            // Handle media uploads
            $existingMedia = json_decode($existing['media_paths'], true) ?? [];
            $keepMedia = $_POST['keep_media'] ?? [];
            $keepMedia = is_array($keepMedia) ? $keepMedia : [];
            $mediaUrls = array_values(array_intersect($existingMedia, $keepMedia));
            $mediaUrls = array_merge($mediaUrls, $this->handleMediaUploads());

            // Update the announcement
            $data = [
                'supply_demand' => $_POST['supply_demand'] ?? $existing['supply_demand'],
                'goods_services' => $_POST['goods_services'] ?? $existing['goods_services'],
                'sub_category_id' => $_POST['sub_category_id'] ?? $existing['sub_category_id'],
                'title' => $_POST['title'] ?? $existing['title'],
                'description' => $_POST['description'] ?? $existing['description'],
                'unit' => $_POST['unit'] ?? $existing['unit'],
                'initial_suggested_price' => $_POST['initial_suggested_price'] ?? $existing['initial_suggested_price'],
                'start_date' => $_POST['start_date'] ?? $existing['start_date'],
                'end_date' => $_POST['end_date'] ?? $existing['end_date'],
                'location_limit' => $_POST['location_limit'] ?? $existing['location_limit'],
                'media_paths' => json_encode($mediaUrls),
            ];

            $this->announceService->updateAnnounce($id, $data);
            redirect(route('ietannounce.show', ['id' => $id]));

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect(route('ietannounce.edit', ['id' => $id]));
        }
    }

    /**
     * Delete an announcement.
     */
    public function delete(int $id): void
    {
        $this->announceService->deleteAnnounce($id);
        redirect(route('ietannounce.mine'));
    }

    /**
     * Handle media uploads.
     */
    private function handleMediaUploads(): array
    {
        $mediaUrls = [];
        if (!isset($_FILES['media_uploads']) || !is_array($_FILES['media_uploads']['name'])) {
            return $mediaUrls;
        }

        foreach ($_FILES['media_uploads']['name'] as $index => $originalName) {
            $file = [
                'name' => $originalName,
                'type' => $_FILES['media_uploads']['type'][$index],
                'tmp_name' => $_FILES['media_uploads']['tmp_name'][$index],
                'error' => $_FILES['media_uploads']['error'][$index],
                'size' => $_FILES['media_uploads']['size'][$index],
            ];

            $uploadResult = UploadFile::uploadFromArray('media', $file);
            if ($uploadResult['success']) {
                $mediaUrls[] = $uploadResult['url'];
            }
        }

        return $mediaUrls;
    }

    /**
     * Map filters to keywords.
     */
    private function getKeywordsByFilter(string $filter): array
    {
        return match ($filter) {
            'housing' => ['املاک', 'مسکن', 'مشاور املاک'],
            'food' => ['غذا', 'خوراکی', 'فست فود'],
            'wear' => ['لباس', 'پوشاک', 'لباس مردانه'],
            'transportation' => ['حمل و نقل'],
            'education' => ['آموزشی'],
            default => [],
        };
    }
}