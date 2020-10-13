<?php


namespace Gallery;


use finfo;

class Utils
{
    /**
     * @param $location
     */
    public static function redirect($location): void
    {
        header("Location: $location");
    }

    /**
     * @param bool $success
     * @param string $message
     * @param array $data
     * All messages from back-end processed here.
     */
    public static function sendFinalResponseAsJson($success = true, $message = '', $data = []): void
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        die(@json_encode(['success' => $success, 'message' => $message, 'data' => $data]));
    }

    /**
     * @param $uploadedFile
     * @param bool $userAvatar
     * @return bool
     */
    public static function uploadAndMoveFile($uploadedFile, $userAvatar = false)
    {
        if (!($uploadedFile['error'] === UPLOAD_ERR_OK)) {
            $message = UPLOAD_ERRORS[$uploadedFile['error']];
            self::sendFinalResponseAsJson(false, $message, []);
        }
        if (self::validateProvidedFile($uploadedFile)) {
            $pathname = $userAvatar ? ROOT_PATH . '/admin/includes/resources/uploads/' : ROOT_PATH . '/resources/uploads/';
            if (!is_dir($pathname)) {
                mkdir($pathname);
            }

            $fileExtension  = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
            $fileName       = sprintf('%s.%s', sha1_file($uploadedFile['tmp_name']), $fileExtension);
            $_POST['image'] = $fileName;
            $targetPath     = "{$pathname}" .  $fileName;
            return move_uploaded_file($uploadedFile['tmp_name'], $targetPath);
        }
        return false;
    }

    /**
     * @param $uploadedFile
     * @return bool
     */
    private static function validateProvidedFile($uploadedFile)
    {
        $fileInfo         = new finfo(FILEINFO_MIME_TYPE);
        $fileExtension    = $fileInfo->file($uploadedFile["tmp_name"]);

        $fileExists       = boolval(file_exists($uploadedFile["tmp_name"]));
        $allowedFileType  = in_array($fileExtension, ALLOWED_MIME_TYPES);
        $allowedSize      = boolval($uploadedFile['size'] < MAX_ALLOWED_FILE_SIZE);
        $notMultipleFiles = boolval(!isset($uploadedFile['error']) || !is_array($uploadedFile['error']));
        $noErrors         = ($uploadedFile['error'] === UPLOAD_ERR_OK);

        return ($fileExists && $allowedFileType && $allowedSize && $notMultipleFiles && $noErrors);
    }
}
