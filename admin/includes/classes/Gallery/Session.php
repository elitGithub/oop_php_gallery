<?php


namespace Gallery;


class Session
{
    private bool $signedIn = false;
    public $userID = null;
    private $users;
    public $message = '';
    public $count = 0;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->users = new Users();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkLogin();
        $this->checkMessage();
        $this->visitorCount();
    }

    private function checkLogin() {
        $this->signedIn = boolval(isset($_SESSION['user_id']));
        $this->userID = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : null;
    }

    /**
     * @return bool
     */
    public function isSignedIn(): bool
    {
        return $this->signedIn;
    }

    /**
     * @param $username
     * @param $password
     */
    public function login($username, $password, $userObj = null)
    {
        $user = $userObj;
        if (!$user) {
            $user = $this->users->findUserByEmailAndPassword($username, md5($password));
        }
        $this->userID = $_SESSION['user_id'] = $user->id;
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        $cookieData = json_encode(['user_id' => $this->userID, 'time' => time(), 'token' => $_SESSION['token']]);
        setcookie('login', $cookieData, time() + 3600);
    }

    /**
     * @return null|int
     */
    public function getLoggedInUser() {
        return $this->userID;
    }

    /**
     *
     */
    public function logout() {
        unset($this->userID);
        unset($_SESSION['user_id']);
        $this->signedIn = false;
        unset($_SESSION['token']);
        setcookie('login', '', time() - 3600);
        session_destroy();
    }

    /**
     * @param string $message
     * @return string
     */
    public function message($message = '') {
        if (!empty($message)) {
            $_SESSION['message'] = $message;
        } else {
            return $this->message;
        }
    }

    /**
     *
     */
    private function checkMessage() {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = '';
        }
    }

    public function visitorCount() {
        if (isset($_SESSION['count'])) {
            return $this->count = $_SESSION['count']++;
        }
        return $_SESSION['count'] = 1;
    }
}