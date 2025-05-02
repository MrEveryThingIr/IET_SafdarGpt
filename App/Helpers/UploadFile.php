<?php
declare(strict_types=1);

namespace App\Helpers;

final class UploadFile
{
    private const IMAGE_TYPES = [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
    ];
    private const VIDEO_TYPES = [
        'video/mp4', 'video/webm', 'video/ogg',
    ];
    private const AUDIO_TYPES = [
        'audio/mpeg', 'audio/wav', 'audio/ogg',
    ];
    private const DOCUMENT_TYPES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
    private const ARCHIVE_TYPES = [
        'application/zip',
        'application/x-rar-compressed',
        'application/x-7z-compressed',
    ];

    private const DEFAULT_TYPES = [
        ...self::IMAGE_TYPES,
        ...self::VIDEO_TYPES,
        ...self::AUDIO_TYPES,
        ...self::DOCUMENT_TYPES,
        ...self::ARCHIVE_TYPES,
    ];

    private static array $categories = [
        'image'    => self::IMAGE_TYPES,
        'video'    => self::VIDEO_TYPES,
        'audio'    => self::AUDIO_TYPES,
        'document' => self::DOCUMENT_TYPES,
        'archive'  => self::ARCHIVE_TYPES,
    ];

    public static function uploadFromArray(
        string $category,
        array $file,
        array $allowedTypes = [],
        int $maxSize = 10 * 1024 * 1024
    ): array {
        $result = [
            'success'  => false,
            'filename' => null,
            'path'     => null,
            'url'      => null,
            'error'    => null,
        ];

        $validMimes = $allowedTypes ?: self::$categories[$category] ?? self::DEFAULT_TYPES;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $result['error'] = self::codeToMessage($file['error']);
            return $result;
        }

        if ($file['size'] > $maxSize) {
            $result['error'] = "File exceeds max size of {$maxSize} bytes.";
            return $result;
        }

        $tmpPath = $file['tmp_name'];
        $mimeType = mime_content_type($tmpPath) ?: '';
        if (!in_array($mimeType, $validMimes, true)) {
            $result['error'] = "Invalid file type: {$mimeType}.";
            return $result;
        }

        $originalName = $file['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $base = pathinfo($originalName, PATHINFO_FILENAME);
        $safeBase = preg_replace('/[^A-Za-z0-9_\-]/', '_', $base) ?: 'file';
        $timestamp = time();
        $safeName  = "{$timestamp}_{$safeBase}.{$ext}";

        $uploadDir = base_path("public/assets/uploads/{$category}");
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            $result['error'] = "Failed to create upload directory.";
            return $result;
        }

        $destination = $uploadDir . DIRECTORY_SEPARATOR . $safeName;
        if (!move_uploaded_file($tmpPath, $destination)) {
            $result['error'] = "Failed to move uploaded file.";
            return $result;
        }

        $result['success']  = true;
        $result['filename'] = $safeName;
        $result['path']     = $destination;
        $result['url']      = base_url("assets/uploads/{$category}/{$safeName}");

        return $result;
    }

    private static function codeToMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive.',
            UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
            default               => 'Unknown upload error.',
        };
    }

    public static function uploadDirectory(string $subfolder = ''): string
    {
        $dir = base_path('public/assets/uploads');
        if ($subfolder !== '') {
            $dir .= DIRECTORY_SEPARATOR . trim($subfolder, DIRECTORY_SEPARATOR);
        }
        return $dir;
    }
}
