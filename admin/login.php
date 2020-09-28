<?php

use Gallery\Users;
use Gallery\Utils;

require_once './includes/init.php';
$errMessage = '';
$username = '';
$password = '';
if ($session->isSignedIn()) {
    Utils::redirect('index.php');
}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $users = new Users();
    if ($users->findUserByEmailAndPassword($username, $password)) {
        $session->login($username, $password, $users);
        Utils::redirect('index.php');
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $errMessage = 'User not found.';
    }
}

require_once ('includes/html_forms/login.php');