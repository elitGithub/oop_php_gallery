<?php
require_once '../../includes/init.php';

use Gallery\Session;
use Gallery\Utils;
global $users;

header('Content-Type: application/json');

if (isset($_GET['find_all'])) {
    $data = $users->findAll();
    $data = array_filter($data, function ($datum) {
        $session = new Session();
        return $datum['id'] !== $session->getLoggedInUser();
    });
    Utils::sendFinalResponseAsJson(true, '', array_values($data));
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


