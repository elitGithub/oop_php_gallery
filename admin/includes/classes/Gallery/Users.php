<?php


namespace Gallery;

require_once 'Database.php';

class Users extends Database
{

    public string $username;
    public string $email;
    public string $firstName;
    public string $lastName;
    public string $password;
    public string $createdAt;
    public string $updatedAt;
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
    protected $fillables = ['username', 'email', 'password', 'firstName', 'lastName', 'image'];

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
                if (!empty($postItem)) {
                    $_POST[$postKey] = md5($postItem);
                } else {
                    $_POST[$postKey] = $this->password;
                }
            }

            if (in_array($postKey, ['firstName', 'lastName'])) {
                $_POST[$postKey] = filter_var($postItem, FILTER_SANITIZE_STRING);
                $_POST[$postKey] = preg_replace('/\d+/u', '', $postItem);
            }

            if ($postKey === 'image' && isset($_POST['update_user'])) {
                $_POST[$postKey] = empty($postItem) ? $this->columnFields['image'] : $postItem;
            }
        }

        foreach ($this->fillables as $fillable) {
            if (in_array('update_user', array_keys($_POST))) {
                $_POST['username'] = $this->username;
            }
            $this->columnFields[$fillable] = $_POST[$fillable];
        }
    }

    public function findByUsername($username) {
        $query = "SELECT id FROM `{$this->table}` WHERE username = :username;";
        $this->query($query);
        $this->bind(':username', $username);
        return $this->singleResult();
    }

}