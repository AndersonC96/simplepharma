<?php

namespace App;

class Uploader
{
    private static $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'txt'];
    private static $allowed_mimes = [
        'image/jpeg', 'image/png', 'application/pdf', 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
        'text/plain'
    ];
    private static $max_size = 5 * 1024 * 1024; // 5MB

    /**
     * Upload multiple files securely.
     */
    public static function upload($files, $user_id)
    {
        $uploaded_paths = [];
        $storage_dir = __DIR__ . '/../storage/uploads/' . $user_id . '/';

        if (!is_dir($storage_dir)) {
            mkdir($storage_dir, 0755, true);
        }

        foreach ($files['name'] as $key => $name) {
            if ($files['error'][$key] !== UPLOAD_ERR_OK) continue;

            $tmp_name = $files['tmp_name'][$key];
            $file_size = $files['size'][$key];
            $file_type = mime_content_type($tmp_name);
            $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            // Validation
            if (!in_array($extension, self::$allowed_extensions)) continue;
            if (!in_array($file_type, self::$allowed_mimes)) continue;
            if ($file_size > self::$max_size) continue;

            // Secure filename
            $new_filename = bin2hex(random_bytes(16)) . '.' . $extension;
            $destination = $storage_dir . $new_filename;

            if (move_uploaded_file($tmp_name, $destination)) {
                $uploaded_paths[] = [
                    'original_name' => $name,
                    'stored_path' => 'storage/uploads/' . $user_id . '/' . $new_filename,
                    'mime_type' => $file_type
                ];
            }
        }

        return $uploaded_paths;
    }
}
