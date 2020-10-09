<?php
require_once './includes/init.php';
global $users, $session;
use Gallery\Utils;

$errMessage = '';
$username = '';
$password = '';
if ($session->isSignedIn()) {
    Utils::redirect('index.php');
}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));
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