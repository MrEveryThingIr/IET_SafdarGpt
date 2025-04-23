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

    /** All categories combined */
    private const DEFAULT_TYPES = [
        ...self::IMAGE_TYPES,
        ...self::VIDEO_TYPES,
        ...self::AUDIO_TYPES,
        ...self::DOCUMENT_TYPES,
        ...self::ARCHIVE_TYPES,
    ];

    /** Mapping category key → MIME list */
    private static array $categories = [
        'image'    => self::IMAGE_TYPES,
        'video'    => self::VIDEO_TYPES,
        'audio'    => self::AUDIO_TYPES,
        'document' => self::DOCUMENT_TYPES,
        'archive'  => self::ARCHIVE_TYPES,
    ];

    /**
     * Handle an uploaded file.
     *
     * @param string $category     One of 'image','video','audio','document','archive' (or any custom)
     * @param string $inputName    The <input type="file" name="…">
     * @param array  $allowedTypes Optional override MIME list
     * @param int    $maxSize      Max bytes (default 10 MB)
     *
     * @return array{
     *   success: bool,
     *   filename: string|null,
     *   path: string|null,
     *   url: string|null,
     *   error: string|null
     * }
     */
    public static function upload(
        string $category,
        string $inputName,
        array  $allowedTypes = [],
        int    $maxSize      = 10 * 1024 * 1024
    ): array {
        $result = [
            'success'  => false,
            'filename' => null,
            'path'     => null,
            'url'      => null,
            'error'    => null,
        ];

        // Determine which MIME types to allow
        if (!empty($allowedTypes)) {
            $validMimes = $allowedTypes;
        } elseif (isset(self::$categories[$category])) {
            $validMimes = self::$categories[$category];
        } else {
            $validMimes = self::DEFAULT_TYPES;
        }

        // Check that file was uploaded
        if (!isset($_FILES[$inputName])) {
            $result['error'] = "No file uploaded under '{$inputName}'.";
            return $result;
        }
        $file = $_FILES[$inputName];

        // PHP upload error?
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $result['error'] = self::codeToMessage($file['error']);
            return $result;
        }

        // Size check
        if ($file['size'] > $maxSize) {
            $result['error'] = "File exceeds max size of {$maxSize} bytes.";
            return $result;
        }

        // MIME type check
        $tmpPath  = $file['tmp_name'];
        $mimeType = mime_content_type($tmpPath) ?: '';
        if (!in_array($mimeType, $validMimes, true)) {
            $result['error'] = "Invalid file type: {$mimeType}.";
            return $result;
        }

        // Build a safe filename
        $originalName = $file['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $base = pathinfo($originalName, PATHINFO_FILENAME);
        // Replace any non-alphanumeric/hyphen/underscore with underscore
        $safeBase = preg_replace('/[^A-Za-z0-9_\-]/', '_', $base) ?: 'file';
        $timestamp = time();
        $safeName  = "{$timestamp}_{$safeBase}.{$ext}";

        // Ensure target directory exists
        $uploadDir = base_path("public/assets/uploads/{$category}");
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            $result['error'] = "Failed to create upload directory.";
            return $result;
        }

        // Move the file
        $destination = $uploadDir . DIRECTORY_SEPARATOR . $safeName;
        if (!move_uploaded_file($tmpPath, $destination)) {
            $result['error'] = "Failed to move uploaded file.";
            return $result;
        }

        // Success
        $result['success']  = true;
        $result['filename'] = $safeName;
        $result['path']     = $destination;
        $result['url']      = base_url("assets/uploads/{$category}/{$safeName}");

        return $result;
    }

    /**
     * Translate PHP file‑upload error codes.
     */
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

    /**
 * Return the base upload directory (with optional subfolder).
 */
public static function uploadDirectory(string $subfolder = ''): string
{
    $dir = base_path('public/assets/uploads');
    if ($subfolder !== '') {
        $dir .= DIRECTORY_SEPARATOR . trim($subfolder, DIRECTORY_SEPARATOR);
    }
    return $dir;
}


}


// use App\Helpers\UploadFile;

// // e.g. from a form with <input type="file" name="avatar">
// $result = UploadFile::upload('image', 'avatar', [], 5 * 1024 * 1024);
// if (! $result['success']) {
//     // handle $result['error']
// } else {
//     // $result['filename'], $result['url'], etc.
// }
