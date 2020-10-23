<?php
require_once '../../includes/init.php';

use Gallery\Session;
use Gallery\Utils;
global $users;

$session = new Session();
if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

header('Content-Type: application/json');

if (isset($_GET['find_all'])) {
    $data = $users->findAll();
    $data = [
        'users' => array_values(array_filter($data, function ($datum) use ($session) {
            return $datum['id'] !== $session->getLoggedInUser();
        })),
        'count' => $users->count()
    ];
    Utils::sendFinalResponseAsJson(true, '', $data);
}

if (isset($_GET['find_one']) && isset($_GET['id'])) {
    $users->id = $_GET['id'];
    $users->retrieveEntityInfo();
    Utils::sendFinalResponseAsJson(true, '', $users->columnFields);
}

if (isset($_GET['find_by_username']) && isset($_GET['username'])) {
    $exist = $users->findByUsername($_GET['username']);
    if ($exist) {
        Utils::sendFinalResponseAsJson(false, 'User already exists', []);
    }
    Utils::sendFinalResponseAsJson(true, '', []);
}


