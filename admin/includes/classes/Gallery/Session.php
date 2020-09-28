<?php


namespace Gallery;


class Session
{
    private bool $signedIn = false;
    public $userID = null;
    public $message = '';

    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
        $this->checkLogin();
        $this->checkMessage();
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
            $user = (new Users())->findUserByEmailAndPassword($username, $password);
        }
        $this->userID = $_SESSION['user_id'] = $user->id;
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
}

$session = new Session();