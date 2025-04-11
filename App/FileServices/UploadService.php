<?php

namespace App\FileServices;

use App\Helpers\Sanitizer;

class UploadService
{
    protected static array $defaultAllowedTypes = [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
        'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'audio/mpeg', 'audio/wav', 'audio/ogg',
        'video/mp4', 'video/webm', 'video/ogg',
        'application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed',
    ];

    /**
     * Upload a file to category directory under /public/assets/uploads/
     */
    public static function uploadFile(
        string $uploadCategory,
        string $inputName,
        array $allowedTypes = [],
        int $maxSize = 10 * 1024 * 1024
    ): string|false {
        if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
            error_log("File upload error: " . ($_FILES[$inputName]['error'] ?? 'No file uploaded'));
            return false;
        }

        $file = $_FILES[$inputName];
        $tmpPath = $file['tmp_name'];
        $originalName = $file['name'];
        $fileSize = $file['size'];
        $mimeType = mime_content_type($tmpPath);

        $allowedTypes = $allowedTypes ?: self::$defaultAllowedTypes;

        if (!in_array($mimeType, $allowedTypes)) {
            error_log("Rejected file due to invalid MIME type: $mimeType");
            return false;
        }

        if ($fileSize > $maxSize) {
            error_log("Rejected file due to exceeding size: $fileSize bytes");
            return false;
        }

        $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $safeBase = Sanitizer::sanitizeFilename(pathinfo($originalName, PATHINFO_FILENAME));
        $safeName = time() . '_' . $safeBase . '.' . $fileExt;

        $targetDir = self::uploadsPath($uploadCategory);

        if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
            error_log("Failed to create directory: $targetDir");
            return false;
        }

        $finalPath = rtrim($targetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $safeName;

        if (!move_uploaded_file($tmpPath, $finalPath)) {
            error_log("Failed to move uploaded file to: $finalPath");
            return false;
        }

        return $safeName;
    }

    /**
     * Get full path to uploads directory for given category.
     */
    public static function uploadsPath(string $subfolder = ''): string
    {
        return base_path('public/assets/uploads/' . trim($subfolder, '/'));
    }

    /**
     * Generate full URL to access uploaded file.
     */
    public static function uploadsUrl(string $filename = ''): string
    {
        return base_url('assets/uploads/' . ltrim($filename, '/'));
    }
}
