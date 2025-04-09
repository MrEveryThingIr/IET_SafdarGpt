<?php

namespace App\FileServices;

use App\Helpers\Sanitizer;

class UploadService
{
    protected static array $defaultAllowedTypes = [
        // Images
        'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
        // Documents
        'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        // Audio
        'audio/mpeg', 'audio/wav', 'audio/ogg',
        // Video
        'video/mp4', 'video/webm', 'video/ogg',
        // Archives
        'application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed'
    ];

    /**
     * Upload a file with sanitization and security validations.
     */
    public static function uploadFile(
        string $uploadCategory,
        string $inputName,
        array $allowedTypes = [],
        int $maxSize = 10 * 1024 * 1024 // 10MB
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

        // Use default types if none provided
        $allowedTypes = $allowedTypes ?: self::$defaultAllowedTypes;

        // MIME Validation
        if (!in_array($mimeType, $allowedTypes)) {
            error_log("Rejected file due to invalid MIME: $mimeType");
            return false;
        }

        // Size check
        if ($fileSize > $maxSize) {
            error_log("Rejected file due to size: $fileSize bytes");
            return false;
        }

        // Sanitize and build safe file name
        $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $safeBase = Sanitizer::sanitizeFilename(pathinfo($originalName, PATHINFO_FILENAME));
        $safeName = time() . '_' . $safeBase . '.' . $fileExt;

        // Prepare final path
        $targetDir = self::uploadsPath($uploadCategory);
        if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
            error_log("Failed to create upload directory: $targetDir");
            return false;
        }

        $finalPath = $targetDir . DIRECTORY_SEPARATOR . $safeName;

        // Move uploaded file
        if (!move_uploaded_file($tmpPath, $finalPath)) {
            error_log("Failed to move uploaded file to: $finalPath");
            return false;
        }

        return $safeName;
    }

    /**
     * Absolute upload path.
     */
    public static function uploadsPath(string $subfolder = ''): string
    {
        $base = realpath(__DIR__ . '/../../../public/assets/uploads') ?: __DIR__ . '/../../../public/assets/uploads';
        if (!is_dir($base)) {
            mkdir($base, 0755, true);
        }

        return rtrim($base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($subfolder, DIRECTORY_SEPARATOR);
    }

    /**
     * Publicly accessible URL to uploaded file.
     */
    public static function uploadsUrl(string $filename = ''): string
    {
        return rtrim(self::baseUrl('assets/uploads'), '/') . '/' . ltrim($filename, '/');
    }

    protected static function baseUrl(string $path = ''): string
    {
        $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443
            ? "https://" : "http://";

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

        return $protocol . $host . $base . '/' . ltrim($path, '/');
    }
}
