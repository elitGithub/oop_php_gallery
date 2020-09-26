<?php


namespace Gallery;

require_once 'Database.inc.php';

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
    
    public function findUser($username, $password) {
        $query = "SELECT * FROM `{$this->table}` WHERE username = :username AND password = :password LIMIT 1;";
        $this->query($query);
        $this->bind(':username', $username);
        $this->bind(':password', $password);
        $userData = $this->singleResult();
        if ($this->stmt->rowCount() > 0) {
            foreach ($userData as $column => $value) {
                $this->assignObjectVars($column, $value);
            }
        }
    }

    private function assignObjectVars($column, $value)
    {
        $this->{$column} = $value;
    }

}