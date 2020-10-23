<?php


namespace Gallery;

use Gallery\Utils;

class Photos extends Database
{
    public string $title;
    public string $description;
    public string $alt_text;
    public string $caption;
    public string $filename;
    public string $type;
    public string $size;
    public static string $tmp_path;
    public array $customErrors = [];

    const UPLOAD_ERRORS = [
        UPLOAD_ERR_OK         => 'There is no error',
        UPLOAD_ERR_INI_SIZE	  => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
    ];

     /**
     * @var string
     */
    protected string $table = 'photos';
    protected $fillables = ['title', 'description', 'alt_text', 'caption', 'filename', 'type', 'size'];


    /**
     * @param $uploadedFile
     * @return bool
     */
    public function uploadFile($uploadedFile) {
        if (empty($uploadedFile) || !$uploadedFile || !is_array($uploadedFile)) {
            $this->customErrors[] = 'There is no file to upload.';
            return false;
        }

        if (!($uploadedFile['error'] === UPLOAD_ERR_OK)) {
            $this->customErrors[] = Photos::UPLOAD_ERRORS[$uploadedFile['error']];
            return false;
        }

        $fileExtension  = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        $fileName       = sprintf('%s.%s', sha1_file($uploadedFile['tmp_name']), $fileExtension);
        $this->filename = IMAGES_FILE_URL . $fileName;
        $this->type     = $uploadedFile['type'];
        $this->size     = $uploadedFile['size'];
        $success        = Utils::uploadAndMoveFile($uploadedFile);

        if (!$success) {
            $this->customErrors[] = 'Unable to write file to disk.';
            return $success;
        }

        foreach ($_POST as $postKey => $postItem) {
            $this->assignObjectVars($postKey, $postItem);
        }

        foreach ($this->fillables as $fillable) {
            $this->columnFields[$fillable] = $this->{$fillable};
        }
        $this->save();
        return empty($this->customErrors);
    }
}

