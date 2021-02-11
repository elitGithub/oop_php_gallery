<?php


namespace Gallery;


use finfo;

class Utils {
    /**
     * @param string $location
     */
    public static function redirect(string $location): void {
        header("Location: $location");
    }

    /**
     * @param bool $success
     * @param string $message
     * @param array $data
     * All messages from back-end processed here.
     */
    public static function sendFinalResponseAsJson(bool $success = true, string $message = '', $data = []): void {
        if (!is_array($data)) {
            $data = [$data];
        }
        session_write_close();
        die(@json_encode(['success' => $success, 'message' => $message, 'data' => $data]));
    }

    /**
     * @param array $uploadedFile
     * @param bool $userAvatar
     * @return bool
     */
    public static function uploadAndMoveFile(array $uploadedFile, bool $userAvatar = false): bool {
        if (!($uploadedFile['error'] === UPLOAD_ERR_OK)) {
            $message = Photos::UPLOAD_ERRORS[$uploadedFile['error']];
            self::sendFinalResponseAsJson(false, $message, []);
        }
        if (self::validateProvidedFile($uploadedFile)) {
            $pathname = $userAvatar ? USER_AVATARS_UPLOAD_DIR : SITE_IMAGES_UPLOAD_DIR;
            if (!is_dir($pathname)) {
                mkdir($pathname);
            }

            $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
            $fileName = sprintf('%s.%s', sha1_file(Photos::$tmp_path), $fileExtension);
            $_POST['image'] = $userAvatar ? USER_AVATARS_FILE_URL . $fileName : $fileName;
            $targetPath = "{$pathname}" . $fileName;

            return move_uploaded_file(Photos::$tmp_path, $targetPath);
        }

        return false;
    }

    /**
     * @param $uploadedFile
     * @return bool
     */
    private static function validateProvidedFile($uploadedFile): bool {
        Photos::$tmp_path = $uploadedFile["tmp_name"];
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $fileExtension = $fileInfo->file(Photos::$tmp_path);

        $fileExists = boolval(file_exists(Photos::$tmp_path));
        $allowedFileType = in_array($fileExtension, ALLOWED_MIME_TYPES);
        $allowedSize = boolval($uploadedFile['size'] < MAX_ALLOWED_FILE_SIZE);
        $notMultipleFiles = boolval(!isset($uploadedFile['error']) || !is_array($uploadedFile['error']));
        $noErrors = ($uploadedFile['error'] === UPLOAD_ERR_OK);

        return ($fileExists && $allowedFileType && $allowedSize && $notMultipleFiles && $noErrors);
    }

    public static function editorKey() {
        global $textEditorKey;
        echo $textEditorKey;
    }
}
