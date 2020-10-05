<?php


namespace Gallery;

require_once 'Database.php';

class Users extends Database
{

    public $id;
    public string $username;
    public string $email;
    public string $firstName;
    public string $lastName;
    public string $password;
    public string $createdAt;
    public string $updatedAt;
    public $entityDataColumns;
    const EXCLUDED_FIELDS = [
        'createdAt',
        'updatedAt',
        'username',
        'id',
    ];

    /**
     * @var string
     */
    protected string $table = 'users';

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->entityDataColumns = $this->getSchemaColumns();
    }
    
    public function findUserByEmailAndPassword($username, $password) {
        $query = "SELECT * FROM `users` WHERE username = :username AND password = :password LIMIT 1;";
        $this->query($query);
        $this->bind(':username', $username);
        $this->bind(':password', $password);
        $userData = $this->singleResult();
        if ($this->stmt->rowCount() > 0) {
            foreach ($userData as $column => $value) {
                $this->assignObjectVars($column, $value);
            }
            return $this;
        }
        return false;
    }

    private function assignObjectVars($column, $value)
    {
        $this->{$column} = $value;
    }

    public function validateRequestObject()
    {
        if (!is_array($_POST) || empty($_POST)) {
            Utils::sendFinalResponseAsJson(false, 'Wrong request data', []);
        }

        foreach ($_POST as $postKey => $postItem) {
            if ($postKey === 'email') {
                $_POST[$postKey] = filter_var($postItem, FILTER_SANITIZE_EMAIL);
            }
            if ($postKey === 'password') {
                $_POST[$postKey] = md5($postItem);
            }
            if (in_array($postKey, ['firstName', 'lastName'])) {
                $_POST[$postKey] = filter_var($postItem, FILTER_SANITIZE_STRING);
                $_POST[$postKey] = preg_replace('/\d+/u', '', $postItem);
            }
        }
    }

}