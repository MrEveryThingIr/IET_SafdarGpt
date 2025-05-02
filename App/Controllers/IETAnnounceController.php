<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\HTMLRenderer\Navbar;
use App\HTMLRenderer\Sidebar;
use App\HTMLRenderer\Layout;
use App\Models\IETAnnounce;
use App\Helpers\UploadFile;
use Exception;
class IETAnnounceController extends BaseController
{
    private IETAnnounce $announceModel;

    public function __construct()
    {
        $navbar = new Navbar([
            'brand' => 'IET System',
            'items' => [
                ['label' => 'پروفایل', 'href' => '#'],
                ['label' => 'خروج', 'href' => '#'],
            ]
        ]);

        $sidebar = new Sidebar([
            'items' => [
                ['label' => 'اعلام عرضه یا تقاضا', 'href' => route('ietannounce.create')],
                ['label' => 'اعلام‌های من', 'href' => route('ietannounce.mine')],
                ['label' => 'همه‌ی اعلام‌ها', 'href' => route('ietannounce.all')],
            ]
        ]);

        $this->layout = new Layout($navbar, $sidebar, [
            'title' => 'اعلام عرضه یا تقاضا',
            'template' => 'layouts/main_layout',
            'scriptHelpers' => [] // method-level override
        ]);

        $this->announceModel = new IETAnnounce();
    }

    public function create(): void
    {
        $this->render('iet_announce/create', [], ['categories', 'filePreview']);
    }

    public function store(): void
{    
    //     echo '<pre>';
    // print_r($_FILES['media_uploads']);
    // exit;
    // Validate CSRF token if you have one
    // if (!validateCsrfToken($_POST['_token'] ?? '')) {
    //     $_SESSION['error'] = "Invalid CSRF token";
    //     redirectBack();
    //     return;
    // }

    $mediaUrls = [];
    $maxFiles = 5;
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime'];
    $maxFileSize = 10 * 1024 * 1024; // 10MB

    // Check if files were uploaded
    if (isset($_FILES['media_uploads']) && is_array($_FILES['media_uploads']['name'])) {
        $fileCount = count($_FILES['media_uploads']['name']);
        
        // Validate file count
        if ($fileCount > $maxFiles) {
            $_SESSION['error'] = "حداکثر ۵ فایل مجاز است";
            redirect(route('ietannounce.create'));
            return;
        }

        // Process each file
        for ($i = 0; $i < $fileCount; $i++) {
            // Skip if no file was uploaded for this index
            if ($_FILES['media_uploads']['error'][$i] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            // Check for upload errors
            if ($_FILES['media_uploads']['error'][$i] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "خطا در آپلود فایل";
                continue;
            }

            // Validate file type
            $fileType = $_FILES['media_uploads']['type'][$i];
            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = "نوع فایل غیرمجاز است";
                continue;
            }

            // Validate file size
            $fileSize = $_FILES['media_uploads']['size'][$i];
            if ($fileSize > $maxFileSize) {
                $_SESSION['error'] = "حجم فایل بیش از حد مجاز است";
                continue;
            }

            // Sanitize filename
            $fileName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $_FILES['media_uploads']['name'][$i]);

            // Prepare file array for upload
            $file = [
                'name'     => $fileName,
                'type'     => $fileType,
                'tmp_name' => $_FILES['media_uploads']['tmp_name'][$i],
                'error'    => $_FILES['media_uploads']['error'][$i],
                'size'     => $fileSize,
            ];

            // Upload file
            $uploadResult = UploadFile::uploadFromArray('image', $file);

            if ($uploadResult['success']) {
                $mediaUrls[] = $uploadResult['url'];
            } else {
                $_SESSION['error'] = "خطا در ذخیره فایل";
            }
        }
    }

    // Validate required fields
    $requiredFields = ['supply_demand', 'goods_services', 'title'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error'] = "لطفا تمام فیلدهای ضروری را پر کنید";
            redirect(route('ietannounce.create'));
            return;
        }
    }

    // Prepare data for database
    $data = [
        'user_id' => $_SESSION['user_id'] ?? 1,
        'supply_demand' => $_POST['supply_demand'] ?? '',
        'category' => ($_POST['main_category'] ?? '') . ' - ' . ($_POST['sub_category'] ?? ''),
        'goods_services' => $_POST['goods_services'] ?? '',
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'initial_suggested_price' => $_POST['initial_suggested_price'] ?? null,
        'location_limit' => $_POST['location_limit'] ?? '',
        'media_paths' => !empty($mediaUrls) ? json_encode($mediaUrls) : null,
    ];

    // Save to database
    try {
        $this->announceModel->create($data);
        $_SESSION['success'] = "اعلام با موفقیت ثبت شد";
        redirect(route('ietannounce.mine'));
    } catch (Exception $e) {
        $_SESSION['error'] = "خطا در ثبت اطلاعات";
        redirect(route('ietannounce.create'));
    }
}
    public function mine(): void
    {
        $userId = $_SESSION['user_id'] ?? 1;
        $announces = $this->announceModel->getByUser($userId);
        $this->render('iet_announce/mine', ['announces' => $announces]);
    }

    public function show(int $id): void
    {
        /** @var array|null $announce */
        $announce = $this->announceModel->find($id);
        if (!$announce) {
            $this->render('errors/404', []);
            return;
        }

        $this->render('iet_announce/show', ['announce' => $announce]);
    }

    public function edit(int $id): void
    {
        $announce =(array) $this->announceModel->find($id);
        if (!$announce) {
            $this->render('errors/404', []);
            return;
        }
    
        $mediaUrls = json_decode($announce['media_paths'], true) ?? [];

        $this->render('iet_announce/edit', [
            'announce' => $announce,
            'mediaUrls' => $mediaUrls,
            'existingMediaJs' => json_encode($mediaUrls),
        ], ['filePreview', 'existingMedia']);
        
    }
    

    public function update(int $id): void
    {
//         echo '<pre>';
// print_r($_FILES['media_uploads']);
// exit;

        /** @var array|null $existing */
        $existing = (array) $this->announceModel->find($id);
        if (!$existing) {
            $this->render('errors/404', []);
            return;
        }
    
        $existingMedia = json_decode($existing['media_paths'], true) ?? [];
    
        // Keep only the checked (retained) existing media
        $keepMedia = $_POST['keep_media'] ?? [];
        $keepMedia = is_array($keepMedia) ? $keepMedia : [];
    
        $mediaUrls = array_values(array_intersect($existingMedia, $keepMedia));
    
        // Add new media uploads
        $mediaUrls = [];
    
        if (!empty($_FILES['media_uploads']['name'][0])) {
            foreach ($_FILES['media_uploads']['name'] as $index => $name) {
                $file = [
                    'name'     => $_FILES['media_uploads']['name'][$index],
                    'type'     => $_FILES['media_uploads']['type'][$index],
                    'tmp_name' => $_FILES['media_uploads']['tmp_name'][$index],
                    'error'    => $_FILES['media_uploads']['error'][$index],
                    'size'     => $_FILES['media_uploads']['size'][$index],
                ];
    
                $uploadResult = UploadFile::uploadFromArray('image', $file);
    
                if ($uploadResult['success']) {
                    $mediaUrls[] = $uploadResult['url'];
                }
            }
        }
        
    
        $data = [
            'supply_demand' => $_POST['supply_demand'] ?? $existing['supply_demand'],
            'category' => ($_POST['main_category'] ?? '') . ' - ' . ($_POST['sub_category'] ?? ''),
            'goods_services' => $_POST['goods_services'] ?? $existing['goods_services'],
            'title' => $_POST['title'] ?? $existing['title'],
            'description' => $_POST['description'] ?? $existing['description'],
            'initial_suggested_price' => $_POST['initial_suggested_price'] ?? $existing['initial_suggested_price'],
            'location_limit' => $_POST['location_limit'] ?? $existing['location_limit'],
            'media_paths' => json_encode($mediaUrls),
        ];
    
        $this->announceModel->updateById($data, $id);
        redirect(route('ietannounce.show', ['id' => $id]));
    }
    


    public function delete(int $id): void
    {
        $this->announceModel->delete($id);
        redirect(route('ietannounce.mine'));
    }
}
