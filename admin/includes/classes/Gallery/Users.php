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
    public array $columnFields = [];
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

    /**
     * @param $username
     * @param $password
     * @return $this|false
     */
    public function findUserByEmailAndPassword($username, $password) {
        $query = "SELECT * FROM `{$this->table}` WHERE username = :username AND password = :password LIMIT 1;";
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

    /**
     * @param $column
     * @param $value
     */
    private function assignObjectVars($column, $value): void
    {
        $this->{$column} = $value;
    }

    /**
     * Validate existing post super global
     * Not intended to return errors
     */
    public function purifyPostObject() : void
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

    public function findByUsername($username) {
        $query = "SELECT id FROM `{$this->table}` WHERE username = :username;";
        $this->query($query);
        $this->bind(':username', $username);
        return $this->singleResult();
    }


    public function retrieveEntityInfo(): void
    {
        if (!$this->id) {
            foreach ($this->entityDataColumns as $column) {
                $this->columnFields[$column] = '';
            }
        }

        foreach ($this->findOne($this->id) as $column => $value) {
            $this->columnFields[$column] = $value;
        }
    }
}