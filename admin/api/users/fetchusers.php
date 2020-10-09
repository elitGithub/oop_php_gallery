<?php
require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $session;

header('Content-Type: application/json');

if (!$session->isSignedIn()) {
    session_destroy();
    Utils::redirect('/admin/login.php');
}
if (isset($_GET['find_all'])) {
    Utils::sendFinalResponseAsJson(true, '', $users->findAll());
}

if (isset($_GET['find_one']) && isset($_GET['id'])) {
    Utils::sendFinalResponseAsJson(true, '', $users->findOne($_GET['id']));
}

if (isset($_GET['find_by_username']) && isset($_GET['username'])) {
    $query = 'SELECT id FROM users WHERE username = :username;';
    $users->query($query);
    $users->bind(':username', $_GET['username']);
    $exist = $users->singleResult();
    if ($exist['id']) {
        Utils::sendFinalResponseAsJson(false, 'User already exists', $users->findOne($exist['id']));
    }
    Utils::sendFinalResponseAsJson(true, '', []);
}


